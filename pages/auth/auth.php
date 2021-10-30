<?php 

if(isset($_POST['login_auth'])){
$login = filter_var(trim($_POST['login_auth']),FILTER_SANITIZE_STRING); // проверка на запрещенные знаки и очистка пробелов
$pass = filter_var(trim($_POST['pass_auth']),FILTER_SANITIZE_STRING);
$pass = md5($pass.'troddmdf983430000g0fglfjflh'); // преобразуем в хэш

require __DIR__.'\..\..\config\db.php';

$user = R::findOne('users','login = ? AND pass = ?',[$login,$pass]);

if(count($user) == 0){
	echo "Такой пользователь не найден";  // проверяем на пустой массив
	exit();
}

setcookie('user',$pass, time() + 36000,"/"); // создаем куки файл и прописываем time - время жизни куки в сек , параметр слэш указывает что кука будет доступна на всех страницах,цифра 1 говорит о secure режиме
R::close();
header('Location: /my_note/index.php'); // переадресовываем на другую стр.

}