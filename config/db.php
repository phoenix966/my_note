<?php
require_once __DIR__. '/../config/config.php';
require_once __DIR__. '/../libs/RedBeanPHP5_7-mysql/rb-mysql.php';

$host = $config['db']['url'];
$dbname = $config['db']['name'];
$db_login = $config['db']['login'];
$db_pass = $config['db']['pass'];
 

R::setup( 'mysql:host='. $host .';dbname='. $dbname .'',$db_login, $db_pass); 
R::freeze( TRUE );
 if ( !R::testConnection())
 {
         exit ('Нет соединения с базой данных');
 }