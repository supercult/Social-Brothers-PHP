<?php
session_start();

require_once 'include/facebook.php';

$FacebookAppId = ''; // Facebook App ID
$FacebookAppSecret = ''; // Facebook App Secret
$RedirectLink = 'http://social-brothers-php-supenogaming450820.codeanyapp.com/'; // Callback URL
$FacebookPerms = 'email';  // Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $FacebookAppId,
  'secret' => $FacebookAppSecret
));
$CurrentUser = $facebook->getUser();
?>