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

	$pass = md5($pass.'troddmdf983430000g0fglfjflh'); // создаем md5 хеш с любой доп припиской (сахар)

	require __DIR__.'/../../config/db.php'; // вызываем базу из файла config.php

	mysqli_query($connection,"INSERT INTO `users` (`login`,`name`,`email`,`pass`) VALUES ('$login','$name','$email','$pass')"); //ложим в БД
	
	$users = R::dispense('users');
	$users->login = $login;
	$users->name  = $name;
	$users->email = $email;
	$users->pass  = $pass;
	R::store($users);
	
	R::close(); // закрываем соединение с бд

	header('Location: /my_note/index.php'); // переадресовываем на др страницу
}