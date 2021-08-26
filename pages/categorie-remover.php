<?php

$connection = mysqli_connect('localhost:8889','root','root','note_db');

if($connection == false){
  echo 'Не удалось подключиться к базе данных';
  echo mysqli_connect_error();
  exit();
}


if(isset($_GET['id'])){
  $idForRemove = $_GET['id'];
  mysqli_query($connection,"UPDATE `articles` SET `categorie_id` = 18 WHERE `categorie_id` = '$idForRemove' ");
  mysqli_query($connection,"DELETE FROM `articles_categories` WHERE `id` = '$idForRemove' ");
} else{
  //Что то выведешь!
};

