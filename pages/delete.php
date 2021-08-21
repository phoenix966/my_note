<?php

// $_POST
// $_GET

$connection = mysqli_connect('localhost:8889','root','root','note_db');

if($connection == false){
  echo 'Не удалось подключиться к базе данных';
  echo mysqli_connect_error();
  exit();
}

if(isset($_GET['removeKey'])){
  $removeId = $_GET['removeKey'];
  mysqli_query($connection,"DELETE FROM `articles` WHERE `id` = '$removeId' ");
  mysqli_close($connection);
} else{
  //Что то выведешь!
};