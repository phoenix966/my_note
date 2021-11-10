<?php
require_once __DIR__.'/../../config/config.php';

if(isset($_POST['login'])){ // выполняем проверку на существующее значение
	$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING); // фильтр на защиту от html и т.д а также trim для чистки пробелов
	$name = filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);
	$email = filter_var(trim($_POST['email']),FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);

	$pass = password_hash($pass, PASSWORD_DEFAULT);
	$email_hash = md5($email.'troddmdf983430000g0fglfjflh');
	
	require_once __DIR__.'/../../config/db.php'; // вызываем базу из файла config.php
	$root = $config['root_name'];
	function add_to_bd($login,$name,$email,$pass,$email_hash) {
		$users = R::dispense('users');
		$users->login = $login;
		$users->name  = $name;
		$users->email = $email;
		$users->pass  = $pass;
		$users->hash = $email_hash;
		R::store($users);
		R::close();
	}

	try {
		add_to_bd($login,$name,$email,$pass,$email_hash);
		header('Location: '.$root.'/pages/register-page.php?reg=true');
	} catch (Exception $e) {
		print $e->getMessage();
		header('Location: '.$root.'/pages/register-page.php?reg=false');
	}
	
	
}