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
			<h1 class="register__title">Пожалуйста зарегестрируйтесь: </h1>
			<div class="container">
				<div class="register__wrap">
					<form action="./auth/reg.php" class="register__form" method="POST">
					<div class="register__wrapper">
						<input name="login" id="login" type="text" class="register__input" placeholder="Введите логин" required>
						<input name="name" id="name" type="text" class="register__input" placeholder="Введите имя" required>
						<input name="email" id="email" type="email" class="register__input" placeholder="Введите адрес почты" required>

						<input name="pass" id="pass" type="password" class="register__input" placeholder="Введите пароль" required>

						<button type="submit" class="register__btn">Регистрация</button>
					</div>

				</form>
				</div>
				<h2 class="register__title">или выполните вход:</h2>
				<div class="register__wrap">
					<form action="./auth/auth.php" class="register__form" method="POST">
					<div class="register__wrapper register__wrapper--min">
						<input name="login_auth" id="login_auth" type="text" class="register__input" placeholder="Введите логин" required>
						<input name="pass_auth" id="pass_auth" type="password" class="register__input" placeholder="Введите пароль" required>
						<button type="submit" class="register__btn">Войти</button>
					</div>
				</form>
				</div>
			</div>
		</section>
	</div>
</body>
</html>