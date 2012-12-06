<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';

class LogService
{
    /* @var StoreDB */
    public static $STOREDB;

    public static function log_event($description) {
        $login = 'unknown';
        if(isset($_SESSION['login']) && strlen($_SESSION['login'])) {
            $login = $_SESSION['login'];
        }
        return LogService::$STOREDB->log_event($login, $description);
    }
}
