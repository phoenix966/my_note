<?php

//$_GET
//$_POST

$connection = mysqli_connect('localhost:8889','root','root','note_db');

if($connection == false){
	echo 'не удалось подключится к базе данных!<br>';
	echo mysqli_connect_error();
	exit();
}

if(isset($_POST['temp_id'])){
  //Do whatever you want
  $temp_id = $_POST['temp_id'];
  mysqli_query($connection,"DELETE FROM `temp_id`");
  mysqli_query($connection,"INSERT INTO `temp_id` (`id`) VALUES($temp_id)");
  mysqli_close($connection);
}else{
  //Do whatever you want
  
};