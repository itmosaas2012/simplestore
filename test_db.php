<?php

require_once 'Modules/StoreDB/StoreDB.php';
require_once 'Modules/LogService/LogService.php';

$mysql = new PDO( 'mysql:host=' . 'mysql.thedox.z8.ru' .
        ';port='      .  3306 .
        ';dbname='    . 'db_thedox_18',
    'dbu_thedox_9',
    '69sl3ar0TNW');

$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$mysql->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

StoreDB::$MYSQL = $mysql;

$db = new StoreDB(1);

$user = new User();
$user->login = 'vasya';
$user->email = 'vasya@example.com';
$user->password = 'pass';

$db->user_add($user);

$db->user_remove(2);

LogService::$STOREDB = $db;

LogService::log_event('Ololo log.');