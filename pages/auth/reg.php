<?php
	
if(isset($_POST['login'])){ // выполняем проверку на существующее значение
	$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING); // фильтр на защиту от html и т.д а также trim для чистки пробелов
	$name = filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);
	$email = filter_var(trim($_POST['email']),FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);

	if(mb_strlen($login) < 1 || mb_strlen($login) > 90){ // проверка на длину логина
		echo 'Недопустимая длина логина';
		exit();
	}
	if(mb_strlen($pass) < 1 || mb_strlen($pass) > 90){ // проверка на длину пароля
		echo 'Недопустимая длина пароля (от 2 до 6 символов)';
		exit();
	}

	$pass = password_hash($pass, PASSWORD_DEFAULT);
	$email_hash = md5($email.'troddmdf983430000g0fglfjflh');
	
	require __DIR__.'/../../config/db.php'; // вызываем базу из файла config.php

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
		header('Location: /my_note/pages/register-page.php?reg=true');
	} catch (Exception $e) {
		print $e->getMessage();
		header('Location: /my_note/pages/register-page.php?reg=false');
	}
	
	
}