<?php

include('../config/db.php');


if(isset($_POST['updateKey'])){
  $updateId = $_POST['updateKey'];
  $title = $_POST['title'];
  $text = $_POST['text'];
  $cat = $_POST['cat_id'];
  $new_cat = $_POST['new_cat'];
  if(isset($new_cat)){
    mysqli_query($connection,"INSERT INTO `articles_categories` (`categorie_title`) VALUES ('$new_cat') ");
    $temp = mysqli_query($connection,"SELECT `id` FROM `articles_categories` WHERE `categorie_title` = '$new_cat' ");
    $new_cat_id = mysqli_fetch_assoc($temp);
    $id = $new_cat_id['id'];
    mysqli_query($connection,"UPDATE `articles` SET `title` = '$title',`text` = '$text',`categorie_id` = '$id' WHERE `id` = '$updateId' ");
  }
  mysqli_query($connection,"UPDATE `articles` SET `title` = '$title', `text` = '$text',`categorie_id` = '$cat' WHERE `id` = '$updateId' ");
} else{
  //Что то выведешь!
};