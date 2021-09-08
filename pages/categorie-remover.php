<?php

include('../config/db.php');


if(isset($_GET['id'])){
  $idForRemove = $_GET['id'];
  $defaultCat = 18;
  mysqli_query($connection,"UPDATE `articles` SET `categorie_id` = $defaultCat WHERE `categorie_id` = '$idForRemove' ");
  mysqli_query($connection,"DELETE FROM `articles_categories` WHERE `id` = '$idForRemove' ");
} else{
  //Что то выведешь!
};

