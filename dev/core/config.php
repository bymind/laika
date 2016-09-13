<?php

//TODO move session_start() to any controller
session_start();

// DB config

//$dbHost='a103460.mysql.mchost.ru';
$dbHost='localhost';
$dbName='a103460_macfix';
$dbUser='a103460_macfix';
$dbPass='qwer-1234';

// DB connection
$db = mysql_connect($dbHost,$dbUser,$dbPass);

// report
if (!$db) { echo ("Не могу подключиться к серверу базы данных!"); }
//TODO rewrite with catch

// DB selection
mysql_select_db($dbName,$db);

// DB charset configuration
mysql_query("SET NAMES utf8");