<?php
class SasquatchConfig extends DataObject {

    //this can be overloaded in config, or set in _ss_environment
    private static $path_to_sasquatch_config = '/path/to/sasquatch/config.json';

    private static $summary_fields = [
        'InstallationName' => 'InstallationName'
    ];
    private static $db = [
        'SpotifyUsername' => 'Varchar',
        'SpotifyPassword' => 'Varchar',
        'SlackToken1' => 'Varchar',
        'SlackToken2' => 'Varchar',
        'InstallationName' => 'Varchar',
        'SundayStart' => 'Int',
        'SundayStart' => 'Int',
        'SundayEnd' => 'Int',
        'MondayStart' => 'Int',
        'MondayEnd' => 'Int',
        'TuesdayStart' => 'Int',
        'TuesdayEnd' => 'Int',
        'WednesdayStart' => 'Int',
        'WednesdayEnd' => 'Int',
        'ThursdayStart' => 'Int',
        'ThursdayEnd' => 'Int',
        'FridayStart' => 'Int',
        'FridayEnd' => 'Int',
        'SaturdayStart' => 'Int',
        'SaturdayEnd' => 'Int'

    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $sasquatch_config = $this->config()->get('path_to_sasquatch_config');
        if(file_exists($sasquatch_config)) {
            $config = $this->readConfigFile();

            $this->update($config);

            $configFields = [
                'SpotifyUsername' => TextField::create('SpotifyUsername'),
                'SpotifyPassword' => TextField::create('SpotifyPassword'),
                'SlackToken1' => TextField::create('SlackToken1'),
                'SlackToken2' => TextField::create('SlackToken2'),
                'SundayStart' => TextField::create('SundayStart'),
                'SundayStart' => TextField::create('SundayStart'),
                'SundayEnd' => TextField::create('SundayEnd'),
                'InstallationName' => TextField::create('InstallationName'),
                'MondayStart' => TextField::create('MondayStart'),
                'MondayEnd' => TextField::create('MondayEnd'),
                'TuesdayStart' => TextField::create('TuesdayStart'),
                'TuesdayEnd' => TextField::create('TuesdayEnd'),
                'WednesdayStart' => TextField::create('WednesdayStart'),
                'WednesdayEnd' => TextField::create('WednesdayEnd'),
                'ThursdayStart' => TextField::create('ThursdayStart'),
                'ThursdayEnd' => TextField::create('ThursdayEnd'),
                'FridayStart' => TextField::create('FridayStart'),
                'FridayEnd' => TextField::create('FridayEnd'),
                'SaturdayStart' => TextField::create('SaturdayStart'),
                'SaturdayEnd' => TextField::create('SaturdayEnd'),
            ];

            $fields->addFieldsToTab('Root.Main', $configFields);


        } else {
//            $fields->removeByName(array_keys($this->config()->get('db')));
            $fields->addFieldToTab('Root.Main',
                LiteralField::create('confignotfound', sprintf(
                    "<div class='special message'>Sasquatch config could not be loaded</div>")
                )
            );
        }
        return $fields;
    }

    private function readConfigFile() {
        $sasquatch_config = $this->config()->get('path_to_sasquatch_config');
        $contents = file_get_contents($sasquatch_config);
        $json = json_decode($contents, true);

        $config = [
            'SpotifyUsername' => isset($json['spotify']['username'])
                ? $json['spotify']['username']
                : null,
            'SpotifyPassword' => isset($json['spotify']['password'])
                ? $json['spotify']['password']
                : null,
            'SlackToken1' => isset($json['auth']['tokens'][0])
                ? $json['auth']['tokens'][0]
                : null,
            'SlackToken2' => isset($json['auth']['tokens'][1])
                ? $json['auth']['tokens'][1]
                : null,
            'InstallationName' => isset($json['sasquatch']['name'])
                ? $json['sasquatch']['name']
                : null,
            'SundayStart' => isset($json['sasquatch']['scheduler']['days'][0]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][0]['startHour']
                : null,
            'SundayEnd' => isset($json['sasquatch']['scheduler']['days'][0]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][0]['stopHour']
                : null,
            'MondayStart' => isset($json['sasquatch']['scheduler']['days'][1]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][1]['startHour']
                : null,
            'MondayEnd' => isset($json['sasquatch']['scheduler']['days'][1]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][1]['stopHour']
                : null,
            'TuesdayStart' => isset($json['sasquatch']['scheduler']['days'][2]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][2]['startHour']
                : null,
            'TuesdayEnd' => isset($json['sasquatch']['scheduler']['days'][2]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][2]['stopHour']
                : null,
            'WednesdayStart' => isset($json['sasquatch']['scheduler']['days'][3]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][3]['startHour']
                : null,
            'WednesdayEnd' => isset($json['sasquatch']['scheduler']['days'][3]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][3]['stopHour']
                : null,
            'ThursdayStart' => isset($json['sasquatch']['scheduler']['days'][4]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][4]['startHour']
                : null,
            'ThursdayEnd' => isset($json['sasquatch']['scheduler']['days'][4]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][4]['stopHour']
                : null,
            'FridayStart' => isset($json['sasquatch']['scheduler']['days'][5]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][5]['startHour']
                : null,
            'FridayEnd' => isset($json['sasquatch']['scheduler']['days'][5]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][5]['stopHour']
                : null,
            'SaturdayStart' => isset($json['sasquatch']['scheduler']['days'][6]['startHour'])
                ? $json['sasquatch']['scheduler']['days'][6]['startHour']
                : null,
            'SaturdayEnd' => isset($json['sasquatch']['scheduler']['days'][6]['stopHour'])
                ? $json['sasquatch']['scheduler']['days'][6]['stopHour']
                : null,
        ];
        return $config;
    }

    public function validate() {
        $result = parent::validate();

        if(!$this->ID) {
            $count = SasquatchConfig::get()->count();

            if($count >= 1) {
                $result->error('This instance can only manage one config');
            }
        }

        return $result;
    }

    public function onAfterWrite() {
        parent::onAfterWrite();

        $this->writeConfigFile();
    }

    private function writeConfigFile() {
        $json = [
            'spotify' => [
                'username' => $this->SpotifyUsername,
                'password' => $this->SpotifyPassword
            ],
            'auth' => [
                'tokens' => [
                    0 => $this->SlackToken1,
                    1 => $this->SlackToken2
                ]
            ],
            'sasquatch' => [
                'name' => $this->InstallationName,
                'scheduler' => [
                    'days' => [
                        0 => [
                            'startHour' => $this->SundayStart,
                            'stopHour' => $this->SundayEnd
                        ],
                        1 => [
                            'startHour' => $this->MondayStart,
                            'stopHour' => $this->MondayEnd
                        ],
                        2 => [
                            'startHour' => $this->TuesdayStart,
                            'stopHour' => $this->TuesdayEnd
                        ],
                        3 => [
                            'startHour' => $this->WednesdayStart,
                            'stopHour' => $this->WednesdayEnd
                        ],
                        4 => [
                            'startHour' => $this->ThursdayStart,
                            'stopHour' => $this->ThursdayEnd
                        ],
                        5 => [
                            'startHour' => $this->FridayStart,
                            'stopHour' => $this->FridayEnd
                        ],
                        6 => [
                            'startHour' => $this->SaturdayStart,
                            'stopHour' => $this->SaturdayEnd
                        ],

                    ]
                ]
            ]
        ];

        $sasquatch_config = $this->config()->get('path_to_sasquatch_config');
        if(file_exists($sasquatch_config)) {
            file_put_contents($sasquatch_config, json_encode($json, JSON_PRETTY_PRINT));
        }
    }
}