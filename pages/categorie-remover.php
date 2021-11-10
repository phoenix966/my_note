<?php

require_once __DIR__.'/../config/db.php';

if(isset($_GET['id'])){
  
  if(isset($_COOKIE['user'])){
    $user_pass_hash = $_COOKIE['user'];
    $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
    $userId = $user_data['id'];  
  }

  $idForRemove = $_GET['id'];
  $default_cat = R::findOne('articles_categories', 'user_id = ? AND default_cat = ?', [$userId,1]);
  $default_id = $default_cat['id'];

  R::exec('UPDATE `articles` SET `categorie_id` = ? WHERE `categorie_id` = ?',[$default_id,$idForRemove]);
  R::exec('DELETE FROM `articles_categories` WHERE `id` = ?',[$idForRemove]);
  R::close();
  
} else{
  //Что то выведешь!
};

