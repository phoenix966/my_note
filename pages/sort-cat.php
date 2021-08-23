<?php

$connection = mysqli_connect('localhost:8889','root','root','note_db');

  if($connection == false){
    echo 'не удалось подключится к базе данных!<br>';
    echo mysqli_connect_error();
    exit();
  }

$result = $_GET['tempId'];

if(isset($result)){
  mysqli_query($connection,"DELETE FROM `temp_cat_id`");
  mysqli_query($connection,"INSERT INTO `temp_cat_id` (`id`) VALUES ('$result')");
}else{
  
}