<?php
/**
 * File:        AccountSettings.php
 * Created by:  roninmax
 * Date:        11/18/12 at 14:33
 * Last Edit:   11/18/12 at 14:33
 */

$view['Content'] = ROOT_IPATH.'Templates/AccountSettings.php';

$_SESSION['userData'] = array();
if (isset($_SESSION['companyID'])){
   $sql = "SELECT name, surname, password, email, tell FROM user_" . $_SESSION['companyID'] . " WHERE login='" . $_SESSION['login'] . "'";

   foreach ($mysql->query($sql) as $row){
       $_SESSION['userData']['name'] = $row['name'];
       $_SESSION['userData']['surname'] = $row['surname'];
       $_SESSION['userData']['password'] = $row['password'];
       $_SESSION['userData']['email'] = $row['email'];
       $_SESSION['userData']['tell'] = $row['tell']; 
   }
}

?>