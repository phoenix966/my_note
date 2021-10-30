<?php
require __DIR__. '/../config/config.php';
require __DIR__. '/../libs/RedBeanPHP5_7-mysql/rb-mysql.php';

$host = $config['db']['url'];
$dbname = $config['db']['name'];
$db_login = $config['db']['login'];
$db_pass = $config['db']['pass'];
 

R::setup( 'mysql:host='. $host .';dbname='. $dbname .'',$db_login, $db_pass); 

 if ( !R::testConnection() )
 {
         exit ('Нет соединения с базой данных');
 }