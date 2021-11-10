<?php

require_once __DIR__.'/../config/db.php';

if(isset($_GET['removeKey'])){
  
  if(isset($_COOKIE['user'])){
    $user_pass_hash = $_COOKIE['user'];
    $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
    $userId = $user_data['id'];  
 }

  $removeId = $_GET['removeKey'];
  $articles = R::exec('DELETE FROM `articles` WHERE `id` = ? AND `user_id` = ? ',[$removeId,$userId]);
  R::close();
} else{
  //Что то выведешь!
};