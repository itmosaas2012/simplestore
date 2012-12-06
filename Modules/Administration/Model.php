<?php
/**
 * File:        Model.php
 * Created by:  Ikarius
 * Date:        11/18/12 at 7:32 PM
 * Last Edit:   11/18/12 at 7:32 PM
 */

function AddUser($mysql)
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

            $sql = '  INSERT INTO user_'.$_SESSION['companyID'].' (login, password, email, name, surname, patronymic, tell, series, number, sex)
                            VALUES ('.$login.','.$password.','.$email.','.$name.','.$surname.','.$patronymic.','.$tell.','.$series.','.$number.','.$sex.')';
            $mysql->exec($sql);

            $view['success'] = 'Account created.';
        }
    }
}