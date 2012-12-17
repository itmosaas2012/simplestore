<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';

class LogService
{
    /* @var StoreDB */
    public static $STOREDB;

    public static function all_events() {
        $sth = LogService::$STOREDB->prepare('select * from %log%');
        $sth->execute();
        $events = array();
        while ($row = $sth->fetchObject())
        {
            $events[] = $row;
        }
        return $events;
    }

    public static function log_event($description) {
        $login = 'unknown';
        if(isset($_SESSION['login']) && strlen($_SESSION['login'])) {
            $login = $_SESSION['login'];
        }
        return LogService::$STOREDB->log_event($login, $description);
    }
}
