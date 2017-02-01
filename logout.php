<?php
//Include FB config file
require_once 'index.php';

//Unset user data from session
unset($_SESSION['userData']);

//Destroy session data
$FacebookApi->destroySession();

//Redirect to homepage
header("Location:index.php");
?>