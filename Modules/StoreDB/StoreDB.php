<?php

require_once __DIR__.'/../Entities/User.php';
require_once __DIR__.'/../Entities/Brand.php';
require_once __DIR__.'/../Entities/Workplace.php';
require_once __DIR__.'/../Entities/Item.php';

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
            '%user%',
            '%workplace%',
            '%brand%',
            '%item%',
            '%log%'
        );

        $this->company_tables = array();
        foreach ($this->tables as $row) {
            $this->company_tables[] = trim($row, '%') . '_' . $this->companyId;
        }
	}

    // User actions
    // user_add(User $user)
    // user_update(User $user)
    // user_remove(int $userID)

    public function user_add(User $user)
    {
        $sth = $this->prepare('select * from %user% where login = :login');
        $sth->bindValue(':login', $user->login, PDO::PARAM_STR);
        $sth->execute();
        if ($sth->fetch()) {
            return false;
        }

        $sth = $this->prepare('insert into %user% set
                                login = :login,
                                password = :password,
                                email = :email,
                                name = :name,
                                surname = :surname,
                                patronymic = :patronymic,
                                tell = :tell,
                                series = :series,
                                number = :number,
                                activated = :activated,
                                sex = :sex,
                                workplaceID = :workplaceID');

        $sth->bindValue(':login', $user->login, PDO::PARAM_STR);
        $sth->bindValue(':password', $user->password, PDO::PARAM_STR);
        $sth->bindValue(':email', $user->email, PDO::PARAM_STR);
        $sth->bindValue(':name', $user->name, PDO::PARAM_STR);
        $sth->bindValue(':surname', $user->surname, PDO::PARAM_STR);
        $sth->bindValue(':patronymic', $user->patronymic, PDO::PARAM_STR);
        $sth->bindValue(':tell', $user->tell, PDO::PARAM_STR);
        $sth->bindValue(':series', $user->series, PDO::PARAM_STR);
        $sth->bindValue(':number', $user->number, PDO::PARAM_STR);
        $sth->bindValue(':activated', $user->activated, PDO::PARAM_INT);
        $sth->bindValue(':sex', $user->sex, PDO::PARAM_INT);
        $sth->bindValue(':workplaceID', $user->workplaceID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function user_update(User $user)
    {
        $sth = $this->prepare('update %user% set
                                login = :login,
                                password = :password,
                                email = :email,
                                name = :name,
                                surname = :surname,
                                patronymic = :patronymic,
                                tell = :tell,
                                series = :series,
                                number = :number,
                                activated = :activated,
                                sex = :sex,
                                workplaceID = :workplaceID
                                where userID = :userID');

        $sth->bindValue(':userID', $user->userID, PDO::PARAM_INT);
        $sth->bindValue(':login', $user->login, PDO::PARAM_STR);
        $sth->bindValue(':password', $user->password, PDO::PARAM_STR);
        $sth->bindValue(':email', $user->email, PDO::PARAM_STR);
        $sth->bindValue(':name', $user->name, PDO::PARAM_STR);
        $sth->bindValue(':surname', $user->surname, PDO::PARAM_STR);
        $sth->bindValue(':patronymic', $user->patronymic, PDO::PARAM_STR);
        $sth->bindValue(':tell', $user->tell, PDO::PARAM_STR);
        $sth->bindValue(':series', $user->series, PDO::PARAM_STR);
        $sth->bindValue(':number', $user->number, PDO::PARAM_STR);
        $sth->bindValue(':activated', $user->activated, PDO::PARAM_INT);
        $sth->bindValue(':sex', $user->sex, PDO::PARAM_INT);
        $sth->bindValue(':workplaceID', $user->workplaceID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function user_remove($userID)
    {
        $sth = $this->prepare('delete from %user% where userID = :userID');
        $sth->bindValue(':userID', (int)$userID, PDO::PARAM_INT);

        return $sth->execute();
    }

    // Workplace actions

    public function workplace_add(Workplace $workplace) {

        $sth = $this->prepare('insert into %workplace% set
                                wpTypeID = :wpTypeID,
                                address = :address');

        $sth->bindValue(':wpTypeID', $workplace->wpTypeID, PDO::PARAM_INT);
        $sth->bindValue(':address', $workplace->address, PDO::PARAM_STR);

        return $sth->execute();
    }

    // Brand actions

    public function brand_add(Brand $brand) {

        $sth = $this->prepare('insert into %brand% set
                                name = :name,
                                site = :site,
                                description = :description');

        $sth->bindValue(':name', $brand->name, PDO::PARAM_STR);
        $sth->bindValue(':site', $brand->site, PDO::PARAM_STR);
        $sth->bindValue(':description', $brand->description, PDO::PARAM_STR);

        return $sth->execute();

    }

    // Item actions

    public function item_add(Item $item) {

        $sth = $this->prepare('insert into %item% set
                                name = :name,
                                description = :description,
                                cost = :cost,
                                categoryID = :categoryID,
                                brandID = :brandID');

        $sth->bindValue(':name', $item->name, PDO::PARAM_STR);
        $sth->bindValue(':description', $item->description, PDO::PARAM_STR);
        $sth->bindValue(':cost', $item->description, PDO::PARAM_INT);
        $sth->bindValue(':categoryID', $item->categoryID, PDO::PARAM_INT);
        $sth->bindValue(':brandID', $item->brandID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function item_update(Item $item) {

        $sth = $this->prepare('update %item% set
                                name = :name,
                                description = :description,
                                cost = :cost,
                                categoryID = :categoryID,
                                brandID = :brandID
                                where itemID = :itemID');

        $sth->bindValue(':itemID', $item->itemID, PDO::PARAM_INT);
        $sth->bindValue(':name', $item->name, PDO::PARAM_STR);
        $sth->bindValue(':description', $item->description, PDO::PARAM_STR);
        $sth->bindValue(':cost', $item->description, PDO::PARAM_INT);
        $sth->bindValue(':categoryID', $item->categoryID, PDO::PARAM_INT);
        $sth->bindValue(':brandID', $item->brandID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function item_remove($itemID) {
        $sth = $this->prepare('delete from %item% where itemID = :itemID');
        $sth->bindValue(':itemID', (int)$itemID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function log_event($login, $description) {
        $sth = $this->prepare('insert into %log% (login, description) values (:login, :description)');
        $sth->bindValue(':login', $login, PDO::PARAM_STR);
        $sth->bindValue(':description', $description, PDO::PARAM_STR);

        return $sth->execute();
    }

    private function prepare($sql) {
        $sql = str_replace($this->tables, $this->company_tables, $sql);
        return StoreDB::$MYSQL->prepare($sql);
    }
	
}