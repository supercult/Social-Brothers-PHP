<?php
session_start();

//Include Facebook SDK
require_once 'include/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '1636343336672953'; //Facebook App ID
$appSecret = 'f4135ace4df1c5977ed39e9bf5cd1cdb'; // Facebook App Secret
$redirectURL = 'http://social-brothers-php-supenogaming450820.codeanyapp.com/'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>