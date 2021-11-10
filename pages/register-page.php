<?php 
	$check = '';
	if(isset($_COOKIE['user'])){
        $user_pass_hash = $_COOKIE['user'];
        $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
        $userId = $user_data['id'];
		$check = 'style="display: none"';  
     }
	 if(isset($_GET['reg']) AND $_GET['reg'] == 'true'){
		$check = 'style="display: none"';
	 }
	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body class="register__body">
	<div class="wrapper">
		<section class="register">
			<h3 class="register__title">
				<?php
					if(isset($_GET['reg'])){
						if($_GET['reg'] == 'true'){
							echo 'Вы успешно зарегестрировались!';
						} else{
							echo 'Возникли ошибки при регистрации!';
						}
					}
				?>
			</h3>
			<div class="container">
				<div  class="register__wrap" <?php echo $check ?>>
				<h1 class="register__title">Пожалуйста зарегестрируйтесь: </h1>
					<form action="./auth/reg.php" class="register__form" method="POST">
					<div class="register__wrapper">
						<input name="login" id="login" type="text" class="register__input" placeholder="Введите логин" require_onced>
						<input name="name" id="name" type="text" class="register__input" placeholder="Введите имя" require_onced>
						<input name="email" id="email" type="email" class="register__input" placeholder="Введите адрес почты" require_onced>

						<input name="pass" id="pass" type="password" class="register__input" placeholder="Введите пароль" require_onced>

						<button type="submit" class="register__btn">Регистрация</button>
					</div>

				</form>
				</div>
				<div class="register__wrap">
				<h3 class="register__text">
				<?php
					if(isset($_GET['auth'])){
						echo 'Ошибка авторизации повторите еще раз!';
					}
				?>
			</h3>
				<h2 class="register__title">Выполните вход: </h2>
					<form action="./auth/auth.php" class="register__form" method="POST">
					<div class="register__wrapper register__wrapper--min">
						<input name="email_auth" id="login_auth" type="email" class="register__input" placeholder="Введите почту" require_onced>
						<input name="pass_auth" id="pass_auth" type="password" class="register__input" placeholder="Введите пароль" require_onced>
						<button type="submit" class="register__btn">Войти</button>
					</div>
				</form>
				</div>
			</div>
		</section>
	</div>
</body>
</html>