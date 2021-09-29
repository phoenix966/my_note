<?php 

if(isset($_POST['login_auth'])){

$login = filter_var(trim($_POST['login_auth']),FILTER_SANITIZE_STRING); // проверка на запрещенные знаки и очистка пробелов
$pass = filter_var(trim($_POST['pass_auth']),FILTER_SANITIZE_STRING);

$pass = md5($pass.'troddmdf983430000g0fglfjflh'); // преобразуем в хэш

require('../../config/db.php');

$result = mysqli_query($connection,"SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'"); // получаем из бд данные в виде объекта
$user = mysqli_fetch_assoc($result); // превращаем  данные в массив для работы в PHP

if(count($user) == 0){
	echo "Такой пользователь не найден";  // проверяем на пустой массив
	exit();
}

setcookie('user',$pass, time() + 3600,"/",'localhost',1); // создаем куки файл и прописываем time - время жизни куки в сек , параметр слэш указывает что кука будет доступна на всех страницах,цифра 1 говорит о secure режиме

mysqli_close($connection);

header('Location: /my_note/index.php'); // переадресовываем на другую стр.

}