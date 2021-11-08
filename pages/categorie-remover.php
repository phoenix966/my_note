<?php

include __DIR__.'/../config/db.php';

if(isset($_GET['id'])){
  $idForRemove = $_GET['id'];

  R::exec('UPDATE `articles` SET `categorie_id` = ? WHERE `categorie_id` = ?',[$default_id,$idForRemove]);
  R::exec('DELETE FROM `articles_categories` WHERE `id` = ?',[$idForRemove]);
  R::close();
  
} else{
  //Что то выведешь!
};

