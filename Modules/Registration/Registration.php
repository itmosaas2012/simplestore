<?php
/**
 * File:        Administration.php
 * Created by:  Ikarius
 * Date:        11/13/12 at 16:56
 * Last Edit:   11/13/12 at 16:56
 */

$view['Content'] = ROOT_IPATH.'Templates/Registration.php';

$view['step'] = 1;
if(isset($_POST['companyName']))
{
    if($_POST['companyName'] == '') $view['error'] = 'Company name empty.';
    else
    {
        $sql = 'SELECT count(companyID) FROM company WHERE nick="'.$_POST['companyName'].'"';
        foreach ($mysql->query($sql) as $row) $companyNameCount = $row['count(companyID)'];

        if($companyNameCount != 0) $view['error'] = 'Company name already exist.';
        else
        {
            $_SESSION['RegistrationDatas'] = array();
            $_SESSION['RegistrationDatas']['companyNick'] = $_POST['companyName'];
            $view['step'] = 2;
        }
    }
}

if(isset($_POST['adminLogin']))
{
    $view['step'] = 2;

    //Testing input
    if($_POST['adminLogin'] == '') $view['error'] = 'Admin login empty.';
    elseif($_POST['adminPassword'] == '') $view['error'] = 'Admin password empty.';
    elseif($_POST['adminPassword'] != $_POST['adminPasswordRepeated']) $view['error'] = 'Admin passwords doesn\'t match.';
    elseif($_POST['adminEmail'] == '') $view['error'] = 'Admin email empty.';
    else
    {
    /*******************
    * Add data to database.
    ******************/
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Need to change the procedure (why NULL doesn't work),
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        $sql =  'call newComp(\''.$_SESSION['RegistrationDatas']['companyNick'].'\',
                                "'.$_POST['adminLogin'].'",
                                "'.$_POST['adminPassword'].'",
                                "'.$_POST['adminEmail'].'");';

        foreach ($mysql->query($sql) as $row) $companyID = $row['ID'];

        $_SESSION['RegistrationDatas']['companyID'] = $companyID;
        $_SESSION['RegistrationDatas']['adminLogin'] = $_POST['adminLogin'];
        $_SESSION['RegistrationDatas']['adminPassword'] = $_POST['adminPassword'];
        $_SESSION['RegistrationDatas']['adminEmail'] = $_POST['adminEmail'];

    /*******************
    * Send e-mail
    ******************/
        $view['companyNick'] = $_SESSION['RegistrationDatas']['companyNick'];
        $view['adminLogin'] = $_SESSION['RegistrationDatas']['adminLogin'];
        $view['adminPassword'] = $_SESSION['RegistrationDatas']['adminPassword'];
        $view['adminEmail'] = $_SESSION['RegistrationDatas']['adminEmail'];

        $code = sha1(   's3?bR78%gr^Vp7A?88'.
                        $_SESSION['RegistrationDatas']['adminLogin'].
                        $_SESSION['RegistrationDatas']['companyNick']);

        $view['code'] = $code;

        require ROOT_IPATH.'Templates/Emails/registrationVerification.php';

        mail($to,$subject,$message,$headers);
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Mail not working for the moment.Need change here! Login!=admin,
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        $sql = 'UPDATE user_'.$_SESSION['RegistrationDatas']['companyID'].' SET activated=1 WHERE login="'.$_SESSION['RegistrationDatas']['adminLogin'].'"';
        $mysql->query($sql);
        $view['step'] = 3;
    }
}

if(isset($_GET['code']))
{
    $code = sha1(   's3?bR78%gr^Vp7A?88'.
                    $_GET['login'].
                    $_GET['comp']);
    if($_GET['code'] == $code)
    {
        $view['step'] = 4;

        foreach ($mysql->query('SELECT companyID FROM company WHERE nick=\''.$_GET['comp'].'\'') as $row) $companyID = $row['companyID'];

    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Need change here! Login!=admin,
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        $sql = 'UPDATE user_'.$companyID.' SET activated=1 WHERE login=admin';
        $mysql->query($sql);
    }
    else $view['error'] = 'Corrupted activation, pleas contact an administrator.';
}