<?php
/**
 * File:        registrationVerification.php
 * Created by:  Ikarius
 * Date:        11/14/12 at 12:41 PM
 * Last Edit:   11/14/12 at 12:41 PM
 *
 * Accessible variable:
 * $view['companyNick']
 * $view['adminLogin']
 * $view['adminPassword']
 * $view['adminEmail']
 * $view['code']
 */

$to = $view['verificationEmail'] ;
$subject = 'Activate your SimpleStore account.';
$message = 'Hello '.$view['adminLogin'].'!
            To activate '.$view['companyNick'].' account,
            would you pleas click to the follow link:
            <a href="http://14.thedox.z8.ru/Registration?code='.$view['code'].'&login='.$view['adminLogin'].'&comp='.$view['companyNick'].'">Activation</a>.';
$headers = 'From: blakmage@hotmail.com';