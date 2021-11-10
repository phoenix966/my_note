<?php

require_once __DIR__.'/../config/db.php';

if(isset($_POST['title'])){

    $title = $_POST['title'];
    $text = $_POST['text'];
    $cat_id = $_POST['cat_id'];
    $new_cat = $_POST['new_cat'];
//     //Получение userID

if(isset($_COOKIE['user'])){
    $user_pass_hash = $_COOKIE['user'];
    $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
    $userId = $user_data['id'];  
 }
    
//     // Логика создания записи

    if(isset($new_cat)){
        R::exec('INSERT INTO `articles_categories` (`categorie_title`,`user_id`) VALUES (?,?)',[$new_cat,$userId]); //ok
        $new_cat_id = R::findOne('articles_categories','categorie_title = ? AND user_id = ?',[$new_cat,$userId]);  // Мы получаем id из БД
        $id = $new_cat_id['id'];
        R::exec('INSERT INTO `articles` (`title`,`text`,`categorie_id`,`user_id`) VALUES (?,?,?,?)',[$title,$text,$id,$userId]);
    }else{
        R::exec('INSERT INTO `articles` (`title`,`text`,`categorie_id`,`user_id`) VALUES (?,?,?,?)',[$title,$text,$cat_id,$userId]);
    }

    R::close();
}else{
//     //Do whatever you want
    
}

