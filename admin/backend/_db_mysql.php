<?php
$host = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "";
$database = "mt";

$db = new PDO("mysql:host=$host;port=$port",
    $username,
    $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("UTC");
session_start();

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");


