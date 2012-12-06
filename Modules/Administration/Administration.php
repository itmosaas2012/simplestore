<?php
/**
 * File:        Controller.php
 * Created by:  Ikarius
 * Date:        11/17/12 at 1:31 PM
 * Last Edit:   11/17/12 at 1:31 PM
 */

require_once 'Model.php';

if($_SESSION['connected'] && $_SESSION['rank'] == 'Администратор')
{
    if( $_SERVER['REQUEST_URI'] == '/Administration') $view['Content'] = 'Templates/Administration/Administration.php';
    elseif (substr_compare($_SERVER['REQUEST_URI'], 'Staff', 16, 5, true)===0)
    {
        addViewRolesAndAddress($mysql);
        $view['Content'] = 'Templates/Administration/Staff.php';
    }
    elseif (substr_compare($_SERVER['REQUEST_URI'], 'AddUser', 16, 7, true)===0)
    {
        addViewRolesAndAddress($mysql);
        $view['Content'] = 'Templates/Administration/Staff.php';
        addUser($mysql);
    }
    elseif (substr_compare($_SERVER['REQUEST_URI'], 'WorkPlaces', 16, 9, true)===0)
    {
        addViewStoreType($mysql);
        $view['Content'] = 'Templates/Administration/WorkPlaces.php';
    }
    elseif (substr_compare($_SERVER['REQUEST_URI'], 'AddWorkPlace', 16, 7, true)===0)
    {
        addViewStoreType($mysql);
        $view['Content'] = 'Templates/Administration/WorkPlaces.php';
        addWorkPlace($mysql);
    }
    else $view['Content'] = 'Templates/Administration/Administration.php';

}