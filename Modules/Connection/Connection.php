<?php

if(!isset($_SESSION['connected']))  $_SESSION['connected'] = false;

if($_SERVER['REQUEST_URI'] == '/Connection')
{
    $view['Content'] = ROOT_IPATH.'Templates/Connection.php';

    if(isset($_POST['company']))
    {
        $sql = 'SELECT companyID FROM company WHERE nick="'.$_POST['company'].'"';
        foreach ($mysql->query($sql) as $row) $companyID = $row['companyID'];

        if(!isset($companyID)) $view['error'] = 'No company with this name.';
        else
        {
            $sql = 'SELECT password, activated FROM user_'.$companyID.' WHERE login=\''.$_POST['login'].'\'';

            foreach ($mysql->query($sql) as $row)
            {
                $password = $row['password'];
                $activated = $row['activated'];
            }

            if(!isset($password)) $view['error'] = 'No user with this login in this company.';
            elseif(!$activated) $view['error'] = 'This account is still not activated, please check the given email at the registration.';
            elseif($_POST['password'] != $password) $view['error'] = 'Incorrect password.';
            else
            {
                $_SESSION['company'] = $_POST['company'];
                $_SESSION['companyID'] = $companyID;
                $_SESSION['login'] = $_POST['login'];

                $sql='SELECT rank.name FROM rank as rank
                        INNER JOIN userRank_'.$companyID.' as userRank
                            ON rank.rankID=userRank.rankID
                        INNER JOIN user_'.$companyID.' as user
                            ON userRank.userID=user.userID
                      WHERE user.login="'.$_SESSION['login'].'"';
                foreach ($mysql->query($sql) as $row) $rank = $row['name'];

                $_SESSION['rank'] = $rank;

                $_SESSION['connected'] = true;
                header('Location: /');//redirection
            }
        }
    }
}



