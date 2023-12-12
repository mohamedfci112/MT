<?php
//kill session
session_start();
$_SESSION["logged"] = '';
$_SESSION["user_id"] = '';
$_SESSION["user_name"] = '';
$_SESSION["user_email"] = '';
$_SESSION["user_phone"] = '';
$_SESSION["shopping_cart"] = '';
header("Location: ../login.php");
?>