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

    private $workplace_id;

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
            $sth = $this->db->prepare('select * from %user% where login = :login');
            $sth->bindValue(':login', $_SESSION['login'], PDO::PARAM_INT);
            $sth->execute();
            $user = $sth->fetchObject();
            if ($user) {
                $this->user_id = intval($user->userID);
                $this->workplace_id = intval($user->workplaceID);
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
        $sth = $this->db->prepare('select i.*,
        (select sum(count) from %object% o where o.workplaceID in (select workplaceID from %workplace% wp where wp.wpTypeID = 1) and o.itemID = i.itemID) as ware_count,
        (select sum(count) from %soldItem% si where si.itemID = i.itemID) as sold_count,
        (select count from %object% o where o.itemID = i.itemID and o.workplaceID = :workplaceID) as left_count
        from %item% i');

        $sth->bindValue(':workplaceID', $this->workplace_id, PDO::PARAM_INT);

        $sth->execute();
        while ($db_item = $sth->fetchObject()) {
            $db_item->ware_count = intval($db_item->ware_count);
            $db_item->sold_count = intval($db_item->sold_count);
            $db_item->left_count = intval($db_item->left_count);
            $items[] = $db_item;
        }
        return $items;
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