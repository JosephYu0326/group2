<?php
$db_host ='localhost';
$db_user = 'root';
$db_pass = '~Apink20110419';
$db_name = 'museum';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$pdo_options=[
    PDO::ATTR_ERRMODE => PDO ::ERRMODE_EXCEPTION, //錯誤報告
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);