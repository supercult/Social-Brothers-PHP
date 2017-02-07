<?php
// Include index.php
require_once 'index.php';

// Unset + Destroy Data
unset($_SESSION['userData']);
$FacebookApi->destroySession();

// Redirect to index.php (Homepage)
header("Location: index.php");
?>