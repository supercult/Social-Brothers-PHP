<?php
//Include index.php
require_once 'index.php';

//Unset user data from session
unset($_SESSION['userData']);

//Destroy data from session
$FacebookApi->destroySession();

//Redirect to index.php (homepage)
header("Location:index.php");
?>