<?php

if($_GET['exit'] == true){

	unset($_COOKIE['user']);
	setcookie('user', null, -1, '/');

	header('Location: /my_note/index.php');
}



