<?php
/**
 * File:        Model.php
 * Created by:  Ikarius
 * Date:        11/18/12 at 7:32 PM
 * Last Edit:   11/18/12 at 7:32 PM
 */

function addViewStoreType($mysql)
{
    global $view;

    $sql = 'SELECT wpTypeID, description FROM wpType';
    foreach ($mysql->query($sql) as $row)
        $view['wpTypes'][] = array('id' => $row['wpTypeID'], 'description' => $row['description']);

    $sql = 'SELECT userID, login FROM user_'.$_SESSION['companyID'];
    foreach ($mysql->query($sql) as $row)
        $view['users'][] = array('id' => $row['userID'], 'login' => $row['login']);
}

function addWorkPlace($mysql)
{
    global $view;

    if(empty($_POST['address'])) $view['error']='Empty address';
    elseif(empty($_POST['workPlace'])) $view['error']='Empty Work place';
    elseif(empty($_POST['responsible'])) $view['error']='Need responsible';
    else
    {
        $capacity = !empty($_POST['capacity'])?$_POST['capacity']:0;

        $sql='INSERT INTO workplace_'.$_SESSION['companyID'].' (wpTypeID, address, capacity, responsible)
                    VALUES("'.$_POST['workPlace'].'","'.$_POST['address'].'",'.$capacity.','.$_POST['responsible'].')';

        $mysql->exec($sql);

        $view['success'] = 'Work place added.';
    }

}

function addViewRolesAndAddress($mysql)
{
    global $view;

    $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'];
    foreach ($mysql->query($sql) as $row)
            $view['workPlaces'][] = array('id' => $row['workplaceID'], 'address' => $row['address']);

    $sql = 'SELECT rankID, name FROM rank';
    foreach ($mysql->query($sql) as $row)
        if($row['name'] != 'Администратор')
            $view['roles'][] = array('id' => $row['rankID'], 'name' => $row['name']);
}

function addUser($mysql)
{
    global $view;

    if(empty($_POST['login'])) $view['error']='Empty login';
    elseif(empty($_POST['password'])) $view['error']='Empty password';
    else
    {
        $sql = 'SELECT count(userID) FROM user_'.$_SESSION['companyID'].' WHERE login="'.$_POST['login'].'"';
        foreach ($mysql->query($sql) as $row) $companyNameCount = $row['count(userID)'];

        if($companyNameCount != 0) $view['error'] = 'Login already exist.';
        else
        {

            $login = '"'.$_POST['login'].'"';
            $password = '"'.$_POST['password'].'"';

            $name = !empty($_POST['name'])?'"'.$_POST['name'].'"':'NULL';
            $surname = !empty($_POST['surname'])?'"'.$_POST['surname'].'"':'NULL';
            $patronymic = !empty($_POST['patronymic'])?'"'.$_POST['patronymic'].'"':'NULL';
            $sex = !empty($_POST['gender'])?$_POST['gender']=='male'?1:0:'NULL';
            $tell = !empty($_POST['phone'])?'"'.$_POST['phone'].'"':'NULL';
            $email = !empty($_POST['email'])?'"'.$_POST['email'].'"':'"NULL"';
            $number = !empty($_POST['passeportNumber'])?'"'.$_POST['passeportNumber'].'"':'NULL';
            $series = !empty($_POST['passeportSerie'])?'"'.$_POST['passeportSerie'].'"':'NULL';
            $workPlace = !empty($_POST['workPlace1'])?$_POST['workPlace1']:'NULL';

            $sql = '  INSERT INTO user_'.$_SESSION['companyID'].' (login, password, email, name, surname, patronymic, tell, series, number, sex, workplaceID, activated)
                            VALUES ('.$login.','.$password.','.$email.','.$name.','.$surname.','.$patronymic.','.$tell.','.$series.','.$number.','.$sex.','.$workPlace.', true)';
            $mysql->exec($sql);

            for($i=1;$i<=100;$i++)
            {
                if(empty($_POST['role'.$i])) break;
                else
                {
                    $sql = 'SELECT userID FROM user_'.$_SESSION['companyID'].' WHERE login="'.$_POST['login'].'"';
                    foreach ($mysql->query($sql) as $row) $userID = $row['userID'];

                    $sql = 'INSERT INTO userRank_'.$_SESSION['companyID'].' (rankID, userID) value ('.$_POST['role'.$i].','.$userID.')';
                    $mysql->exec($sql);
                }
            }

            $view['success'] = 'Account created.';
        }
    }
}