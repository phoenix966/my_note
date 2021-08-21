<?php

$connection = mysqli_connect('localhost:8889','root','root','note_db');

if($connection == false){
  echo 'Не удалось подключиться к базе данных';
  echo mysqli_connect_error();
  exit();
}

if(isset($_POST['updateKey'])){
  $updateId = $_POST['updateKey'];
  $title = $_POST['title'];
  $text = $_POST['text'];
  $cat = $_POST['cat'];
  mysqli_query($connection,"UPDATE `articles` SET `title` = '$title', `text` = '$text',`categorie_id` = '$cat' WHERE `id` = '$updateId' ");
} else{
  //Что то выведешь!
};