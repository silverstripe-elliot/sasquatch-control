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
    "path" => "/var/www/sasquatch-control.db",
);
