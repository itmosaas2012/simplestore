<?php

require_once __DIR__.'/../Entities/User.php';
require_once __DIR__.'/../Entities/Brand.php';
require_once __DIR__.'/../Entities/Workplace.php';
require_once __DIR__.'/../Entities/Item.php';
require_once __DIR__.'/../Entities/DeliveryObject.php';
require_once __DIR__.'/../Entities/Delivery.php';
require_once __DIR__.'/../Entities/Object.php';
require_once __DIR__.'/../Entities/Request.php';

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
            '%deliveryObject%',
            '%delivery%',
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

    public function brand_update(Brand $brand) {

        $sth = $this->prepare('update %brand% set
                                name = :name,
                                site = :site,
                                description = :description
                                where brandID = :brandID');

        $sth->bindValue(':brandID', $brand->brandID, PDO::PARAM_INT);
        $sth->bindValue(':name', $brand->name, PDO::PARAM_STR);
        $sth->bindValue(':site', $brand->site, PDO::PARAM_STR);
        $sth->bindValue(':description', $brand->description, PDO::PARAM_STR);

        return $sth->execute();

    }

    public function brand_remove(Brand $brand) {

        $sth = $this->prepare('delete from %brand% where brandID = :brandID');
        $sth->bindValue(':brandID', $brand->brandID, PDO::PARAM_INT);

        return $sth->execute();
    }


    // Category actions

    public function category_add($name) {

        $sth = $this->prepare('insert into %category% set name = :name');
        $sth->bindValue(':name', $name, PDO::PARAM_STR);

        return $sth->execute();

    }

    public function category_update($categoryID, $name) {

        $sth = $this->prepare('update %category% set name = :name where categoryID = :categoryID');
        $sth->bindValue(':categoryID', (int)$categoryID, PDO::PARAM_INT);
        $sth->bindValue(':name', $name, PDO::PARAM_STR);

        return $sth->execute();

    }

    public function category_remove($categoryID) {

        $sth = $this->prepare('delete %category% where categoryID = :categoryID');
        $sth->bindValue(':categoryID', (int)$categoryID, PDO::PARAM_INT);

        return $sth->execute();

    }


    // Delivery object actions

    public function delivery_object_add(DeliveryObject $deliveryObject) {

        $sth = $this->prepare('insert into %deliveryObject% set
                                objectID = :objectID,
                                deliveryID = :deliveryID,
                                count = :count');

        $sth->bindValue(':objectID', $deliveryObject->objectID, PDO::PARAM_INT);
        $sth->bindValue(':deliveryID', $deliveryObject->deliveryID, PDO::PARAM_INT);
        $sth->bindValue(':count', $deliveryObject->count, PDO::PARAM_INT);

        return $sth->execute();

    }

    public function delivery_object_remove(DeliveryObject $deliveryObject) {

        $sth = $this->prepare('delete from %deliveryObject% where
                                objectID = :objectID,
                                deliveryID = :deliveryID,
                                count = :count');

        $sth->bindValue(':objectID', $deliveryObject->objectID, PDO::PARAM_INT);
        $sth->bindValue(':deliveryID', $deliveryObject->deliveryID, PDO::PARAM_INT);
        $sth->bindValue(':count', $deliveryObject->count, PDO::PARAM_INT);

        return $sth->execute();

    }


    // Delivery actions

    public function delivery_add(Delivery $delivery) {

        $sth = $this->prepare('insert into %delivery% set
                                responsible = :responsible,
                                dispatchTime = :dispatchTime,
                                arrivalTime = :arrivalTime');

        $sth->bindValue(':responsible', $delivery->responsible, PDO::PARAM_STR);
        $sth->bindValue(':dispatchTime', $delivery, PDO::PARAM_STR);
        $sth->bindValue(':arrivalTime', $delivery, PDO::PARAM_STR);

        return $sth->execute();

    }

    public function delivery_remove($deliveryID) {

        $sth = $this->prepare('delete from %delivery% where deliveryID = :deliveryID');
        $sth->bindValue(':deliveryID', $deliveryID, PDO::PARAM_INT);

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


    // Object actions

    public function object_add(Object $object) {

        $sth = $this->prepare('insert into %object% set
                                itemID = :itemID,
                                workplaceID = :workplaceID,
                                count = :count');

        $sth->bindValue(':itemID', $object->itemID, PDO::PARAM_INT);
        $sth->bindValue(':workplaceID', $object->workplaceID, PDO::PARAM_INT);
        $sth->bindValue(':count', $object->count, PDO::PARAM_INT);

        return $sth->execute();

    }

    public function object_remove($objectID) {
        $sth = $this->prepare('delete from %object% where objectID = :objectID');
        $sth->bindValue(':objectID', (int)$objectID, PDO::PARAM_INT);

        return $sth->execute();
    }


    // Request actions

    public function request_add(Request $request) {

        $sth = $this->prepare('insert into %request% set
                                userID = :userID,
                                objectID = :objectID,
                                count = :count');

        $sth->bindValue(':userID', $request->userID, PDO::PARAM_INT);
        $sth->bindValue(':objectID', $request->objectID, PDO::PARAM_INT);
        $sth->bindValue(':count', $request->count, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function request_remove($requestID) {
        $sth = $this->prepare('delete from %request% where requestID = :requestID');
        $sth->bindValue(':requestID', (int)$requestID, PDO::PARAM_INT);

        return $sth->execute();
    }

    // User actions
    // user_add(User $user)
    // user_update(User $user)
    // user_remove(int $userID)

    public function user_add(User $user) {

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

	public function user_rank_add($userID, $rankID) {
		
        $sth = $this->prepare('insert into %userRank% set
                                userID = :userID,
                                rankID = :rankID');

        $sth->bindValue(':userID', $userID, PDO::PARAM_INT);
        $sth->bindValue(':rankID', $rankID, PDO::PARAM_INT);

        return $sth->execute();
	}

    private function user_remove_all_rank($userID) {

        $sth = $this->prepare('delete from %userRank% where
                                userID = :userID');

        $sth->bindValue(':userID', $userID, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function user_ranks($userID) {

        $sth = $this->prepare('select rankID from %userRank% where userID = :userID');
        $sth->bindValue(':userID', $userID, PDO::PARAM_INT);

		$ranks = array();
		while ($rank = $sth->fetchColumn(0)) {
			$ranks[] = $rank;
		}

        return $rank;
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


    // Log

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