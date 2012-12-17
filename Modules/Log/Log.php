<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';
require_once __DIR__.'/../LogService/LogService.php';

StoreDB::$MYSQL = $mysql;

$log = new Log();
$log->init();
$view = $log->view;

class Log {

    public $view;

    /* @var StoreDB */
    private $db;

    public function init() {
        if (!$this->check_permissions()) {
            $this->error_page('Чтобы иметь доступ к этой странице вы должны иметь администратора!');
            return;
        }

        if (isset($_SESSION['companyID']) && $_SESSION['companyID']) {
            $this->db = new StoreDB($_SESSION['companyID']);
            LogService::$STOREDB = $this->db;
        } else {
            $this->error_page('Произошла ошибка...');
            return;
        }

        $this->view['events'] = LogService::all_events();

        $this->view['Content'] = 'Templates/Log/Log.php';
    }

    private function check_permissions() {

        foreach($_SESSION['post'] as $post) {
            if ($post['rank'] == 'Администратор') {
                return true;
            }
        }

        return false;
    }

    private function error_page($text) {
        $this->view['error'] = $text;
        $this->view['Content'] = 'Templates/Purchase/ErrorPage.php';
    }
}