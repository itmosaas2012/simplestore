<?php

class StoreDB {

    /* @var PDO */
    public static $MYSQL;

	private $companyId;

    private $tables;
    private $company_tables;

	public function __construct ($companyId)
	{
		$this->companyId = $companyId;

        $this->tables = array(
            '%brand%',
            '%category%',
            '%deliveryItem%',
            '%delivery%',
            '%soldItem%',
            '%item%',
            '%log%',
            '%object%',
            '%request%',
            '%userRank%',
            '%user%',
            '%workplace%'
        );

        $this->company_tables = array();
        foreach ($this->tables as $row) {
            $this->company_tables[] = trim($row, '%') . '_' . $this->companyId;
        }
	}


    public static function create_company($company_name, $admin_login, $admin_password, $admin_email) {

        $sth = StoreDB::$MYSQL->prepare('select * from company where nick = :nick');
        $sth->bindValue(':nick', $company_name, PDO::PARAM_STR);
        $sth->execute();
        if ($sth->fetch()) {
            return false;
        }

        $sth = StoreDB::$MYSQL->prepare('call newComp(:company_name, :admin_login, :admin_password, :admin_email);');
        $sth->bindValue(':company_name', $company_name, PDO::PARAM_INT);
        $sth->bindValue(':admin_login', $admin_login, PDO::PARAM_STR);
        $sth->bindValue(':admin_password', $admin_password, PDO::PARAM_STR);
        $sth->bindValue(':admin_email', $admin_email, PDO::PARAM_STR);

        return $sth->execute();
    }

    // Log

    public function log_event($login, $description) {
        $sth = $this->prepare('insert into %log% (login, description) values (:login, :description)');
        $sth->bindValue(':login', $login, PDO::PARAM_STR);
        $sth->bindValue(':description', $description, PDO::PARAM_STR);

        return $sth->execute();
    }

    public function prepare($sql) {
        $sql = str_replace($this->tables, $this->company_tables, $sql);
        return StoreDB::$MYSQL->prepare($sql);
    }
	
}