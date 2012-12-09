<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';

StoreDB::$MYSQL = $mysql;

$purchase = new Purchase();
$purchase->init();
$view = $purchase->view;

class Purchase {

    public $view;

    /* @var StoreDB */
    private $db;

    private $user_id;

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

        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $sth = $this->db->prepare('select userID from %user% where login = :login');
            $sth->bindValue(':login', $_SESSION['login'], PDO::PARAM_INT);
            $sth->execute();
            $user_id = $sth->fetchColumn(0);
            if ($user_id) {
                $this->user_id = intval($user_id);
            } else {
                $this->error_page('Произошла ошибка...');
                return;
            }
        }

        if (array_key_exists('form', $_POST) && $_POST['form'] == 'request_items') {
            $this->process_request();
        }

        $this->view['items'] = $this->all_items();

        $this->view['Content'] = 'Templates/Purchase/Purchase.php';
    }

    private function process_request() {
        $added = 0;
        foreach ($_POST['item'] as $item_id => $item_count) {
            $item_id = intval($item_id);
            $item_count = intval($item_count);
            if ($item_count > 0) {
                $this->db_request_add($item_id, $item_count);
                $added++;
            }
        }

        if ($added) {
            $this->view['message_success'] = 'Заказ добавлен.';
        } else {
            $this->view['message_error'] = 'Закажите хотя бы один товар.';
        }
    }

    private function db_request_add($item_id, $item_count) {
        $sth = $this->db->prepare('insert into %request% set
                                userID = :userID,
                                itemID = :itemID,
                                count = :count');

        $sth->bindValue(':userID', $this->user_id, PDO::PARAM_INT);
        $sth->bindValue(':itemID', $item_id, PDO::PARAM_INT);
        $sth->bindValue(':count', $item_count, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function all_items() {
        $items = array();
        $sth = $this->db->prepare('select i.*, o.count, so.count as sold_count from %item% i
                                    left join %object% o on i.itemID = o.itemID
                                    left join %soldItem% so on o.itemID = so.itemID');
        $sth->execute();
        while ($db_item = $sth->fetchObject()) {
            $db_item->count = intval($db_item->count);
            $db_item->sold_count = intval($db_item->sold_count);
            $db_item->left_count = $db_item->count - $db_item->sold_count;
            $items[] = $db_item;
        }
        return $items;
    }

    private function check_permissions() {

        return true;

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