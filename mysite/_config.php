<?php

global $project;
$project = 'mysite';

global $database;
$database = 'sasquatch6';

require_once('conf/ConfigureFromEnv.php');

global $databaseConfig;
$databaseConfig = array(
    "type" => 'SQLiteDatabase',
    "server" => 'none',
    "database" => $database,
    "path" => SS_SQLITE_PATH,
);

if(defined('SASQUATCH_CONFIG_PATH')) {
    Config::inst()->update('SasquatchConfig', 'path_to_sasquatch_config', SASQUATCH_CONFIG_PATH);
}
