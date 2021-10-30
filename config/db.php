<?php
// require_once("./config.php");
// include("../libs/RedBeanPHP5_7-mysql/rb-mysql.php");

// $host = $config['db']['url'];
// $dbname = $config['db']['name'];
// $db_login = $config['db']['login'];
// $db_pass = $config['db']['pass'];

// $connection = mysqli_connect($config['db']['url'], $config['db']['login'], $config['db']['pass'], $config['db']['name']);

// if ($connection == false) {
//     echo 'не удалось подключится к базе данных!<br>';
//     echo mysqli_connect_error();
//     exit();
// };

// R::setup( 'mysql:host='. $host .';dbname='. $dbname .'',$db_login,$db_pass); 
 
require("config/config.php");
require("libs/RedBeanPHP5_7-mysql/rb-mysql.php");

R::setup( 'mysql:host=127.0.0.1;dbname=note_db','root', 'root' ); 

 if ( !R::testConnection() )
 {
         exit ('Нет соединения с базой данных');
 }