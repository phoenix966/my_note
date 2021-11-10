<?php 
require_once __DIR__.'/../../config/config.php';
$root = $config['root_name'];
if(isset($_POST['email_auth'])){
$email = filter_var(trim($_POST['email_auth']),FILTER_SANITIZE_STRING); // проверка на запрещенные знаки и очистка пробелов
$pass = filter_var(trim($_POST['pass_auth']),FILTER_SANITIZE_STRING);

require_once __DIR__.'/../../config/db.php';

$user = R::findOne('users','email = ?',[$email]);

if(password_verify($pass, $user['pass'])){
	setcookie('user',$user['hash'], time() + 3600000,"/",'',1,1); // создаем куки файл и прописываем time - время жизни куки в сек , параметр слэш указывает что кука будет доступна на всех страницах,цифра 1 говорит о secure режиме
}else{
	header('Location: '.$root.'/pages/register-page.php?auth=fail');
	die();
}


R::close();
header('Location: '.$root.'/index.php'); // переадресовываем на другую стр.

}