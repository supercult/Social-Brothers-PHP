<?php
session_start();

//Include Facebook SDK
require_once 'include/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = ''; //Facebook App ID
$appSecret = ''; // Facebook App Secret
$redirectURL = 'http://social-brothers-php-supenogaming450820.codeanyapp.com/'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$CurrentUser = $facebook->getUser();
?>