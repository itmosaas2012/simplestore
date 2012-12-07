<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';

$purchase = new Purchase();
$purchase->init();
$view = $purchase->view;

class Purchase {

    public $view;

    /* @var StoreDB */
    public $db;

    public function init() {
        if (!$this->check_permissions()) {
            $this->error_page('Чтобы иметь доступ к этой странице вы должны иметь роль закупщика склада!');
            return;
        }

        if (isset($_SESSION['companyID']) && $_SESSION['companyID']) {
            $this->db = new StoreDB($_SESSION['companyID']);
        } else {
            $this->error_page('Произошла ошибка...');
            return;
        }

        $this->view['Content'] = 'Templates/Purchase/Purchase.php';
    }

    private function check_permissions() {
        if ($_SESSION['rank'] == 'Закупщик магазина') {
            return true;
        }

        return false;
    }

    private function error_page($text) {
        $this->view['error'] = $text;
        $this->view['Content'] = 'Templates/Purchase/ErrorPage.php';
    }
}