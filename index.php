<?php
/*************************************************************************
 * Starting the session
 ************************************************************************/
session_start();

/*************************************************************************
 * Some usefull define
 ************************************************************************/
define('ROOT_IPATH', $_SERVER['DOCUMENT_ROOT']);

/*************************************************************************
 * Set the default content
 ************************************************************************/
$view['Content'] = 'Templates/Home.php';

/*************************************************************************
 * Database Connection
 ************************************************************************/
try
{
    $mysql = new PDO( 'mysql:host=' . 'localhost' .
                            ';port='      .  3306 .
                            ';dbname='    . 'simplestore',
                                            'itmo',
                                            'itmosaas2012',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
}
catch(Exception $e)
{
    echo 'Error : '.$e->getMessage().'<br />';
    echo 'N°: '.$e->getCode();
}

/*************************************************************************
 * Router
 ************************************************************************/
if($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') ;
elseif($_SERVER['REQUEST_URI'] === '/Registration') require_once 'Modules/Registration/Registration.php';
elseif($_SERVER['REQUEST_URI'] === '/Logout') require_once 'Modules/Disconection/Disconection.php';
elseif($_SERVER['REQUEST_URI'] === '/Settings') require_once 'Modules/Personal/AccountSettings.php';
elseif(substr_compare($_SERVER['REQUEST_URI'], '/Administration', 0, 15, true)===0) require_once 'Modules/Administration/Administration.php';

require_once 'Modules/Connection/Connection.php';//Have to be included in all cases.
require_once 'Modules/Menu/Menu.php';//Have to be included in all cases.

/*************************************************************************
 *  Template
 ************************************************************************/
require_once 'Templates/index.php';
