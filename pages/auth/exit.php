<?php
require_once __DIR__.'/../../config/config.php';

if($_GET['exit'] == true){

	unset($_COOKIE['user']);
	setcookie('user', null, -1, '/');

	$root = $config['root_name'];
	header('Location: '.$root.'/index.php');
}



