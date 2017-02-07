<?php
require_once 'index.php';

unset($_SESSION['userData']);
$FacebookApi->destroySession();

header("Location: index.php");
?>