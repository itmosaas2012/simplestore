<?php

require_once __DIR__.'/../StoreDB/StoreDB.php';
require_once __DIR__.'/../LogService/LogService.php';

StoreDB::$MYSQL = $mysql;

$settings = new Settings();
$settings->init();
$view = $settings->view;

class Settings {

    public $view;

    /* @var StoreDB */
    private $db;
    private $user_id;

    public function init() {
        if (!$this->check_permissions()) {
            $this->error_page('Вы хотите просто так получить доступ к этой странице? Наивные... Залогиньтесь, пожалуйста!');
            return;
        }

        if (isset($_SESSION['companyID']) && $_SESSION['companyID']) {
            $this->db = new StoreDB($_SESSION['companyID']);
			LogService::$STOREDB = $this->db;
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
            } else {
                $this->error_page('Произошла ошибка...');
				LogService::log_event('Произошла ошибка');
                return;
            }
        }

        if (array_key_exists('form', $_POST) && $_POST['form'] == 'request_items') {
            $this->process_request();
        }

        $this->view['items'] = $this->all_items();

        $this->view['Content'] = 'Templates/Personal/Settings.php';
    }

    private function process_request() {
        $added = 0;
        $surname = trim($_POST['familyName']); htmlspecialchars($surname); mysql_escape_string($surname);
	    $name = trim($_POST['givenName']); htmlspecialchars($name); mysql_escape_string($name);
	    $tell = trim($_POST['phone']); htmlspecialchars($tell); mysql_escape_string($tell);
	    $email = trim($_POST['email']); htmlspecialchars($email); mysql_escape_string($email);
	    $pass = trim($_POST['password']); htmlspecialchars($pass); mysql_escape_string($pass);
	    $pass2 = trim($_POST['password2']); htmlspecialchars($pass2); mysql_escape_string($pass2);
	
	    if ($pass != "" && $pass2 != ""){
	        if ($pass == $pass2){
			    $this->db_request_update($name, $surname, $pass, $email, $tell);
				$added++;
		    }
		    else{
		        $this->view['message_error'] = 'Пароли не совпадают.';
		    }
	    }
	    else{
		    $this->view['message_error'] = 'Пароли не введены.';
	    }	

        if ($added) {
            $this->view['message_success'] = 'Данные успешно обновлены.';
			LogService::log_event('Данные успешно обновлены');
        } else {
            $this->view['message_error'] = 'Введите данные для обновления.';
        }
    }

    private function db_request_update($name, $surname, $pass, $email, $tell) {
        $sth = $this->db->prepare('UPDATE %user% SET name = :user_name, surname = :user_surname, password = :user_password, email = :user_email, tell = :user_tell WHERE login = :user_login');

        $sth->bindValue(':user_name', $name, PDO::PARAM_STR);
		$sth->bindValue(':user_surname', $surname, PDO::PARAM_STR);
		$sth->bindValue(':user_password', $pass, PDO::PARAM_STR);
		$sth->bindValue(':user_email', $email, PDO::PARAM_STR);
		$sth->bindValue(':user_tell', $tell, PDO::PARAM_STR);
		$sth->bindValue(':user_login', $_SESSION['login'], PDO::PARAM_STR);

        return $sth->execute();
    }

    public function all_items() {
        $items = array();
        $sth = $this->db->prepare('SELECT name as name, surname as surname, password as password, email as email, tell as tell FROM %user% WHERE login = :user_login');
		$sth->bindValue(':user_login', $_SESSION['login'], PDO::PARAM_STR);
        $sth->execute();
        while ($db_item = $sth->fetchObject()) {
            $db_item->name = $db_item->name;
			$db_item->surname = $db_item->surname;
			$db_item->password = $db_item->password;
			$db_item->email = $db_item->email;
			$db_item->tell = $db_item->tell;
            $items[] = $db_item;
        }
        return $items;
    }

    private function check_permissions() {
        
        if ($_SESSION['connected']) {
            return true;
        }

        return false;
    }

    private function error_page($text) {
        $this->view['error'] = $text;
        $this->view['Content'] = 'Templates/Seller/ErrorPage.php';
    }
}
