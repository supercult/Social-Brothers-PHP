<?php
//Include FB config file
require_once 'config.php';

//Unset user data from session
unset($_SESSION['userData']);

//Destroy session data
$facebook->destroySession();

//Redirect to homepage
header("Location:index.php");
?>