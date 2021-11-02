<?php

require __DIR__.'/../config/db.php';

if(isset($_POST['title'])){

    $title = $_POST['title'];
    $text = $_POST['text'];
    $cat_id = $_POST['cat_id'];
    $new_cat = $_POST['new_cat'];

    // $userId = -1;

//     //Получение userID

    if(isset($_COOKIE['user'])){

     $user_pass_temp = $_COOKIE['user'];
     $user_data = R::findOne('users','pass = ?',[$user_pass_temp]);   //ok
     $userId = $user_data['id'];
     
}
    
//     // Логика создания записи

    if(isset($new_cat)){
        R::exec('INSERT INTO `articles_categories` (`categorie_title`,`user_id`) VALUES (?,?)',[$new_cat,$userId]); //ok
        $new_cat_id = R::findOne('articles_categories','categorie_title = ? AND user_id = ?',[$new_cat,$userId]);  // Мы получаем id из БД
        $id = $new_cat_id['id'];
       
        R::exec('INSERT INTO `articles` (`title`,`text`,`categorie_id`,`user_id`) VALUES (?,?,?,?)',[$title,$text,$id,$userId]);
        // $articles = R::dispense('articles');
        // $articles->title = $title;
        // $articles->text = $text;
        // $articles->categorie_id = $id;   // создаем новую запись
        // $articles->user_id = $userId;
        // R::store($articles);
    }else{
        R::exec('INSERT INTO `articles` (`title`,`text`,`categorie_id`,`user_id`) VALUES (?,?,?,?)',[$title,$text,$cat_id,$userId]);
        // $articles = R::dispense('articles');
        // $articles->title = $title;
        // $articles->text = $text;
        // $articles->categorie_id = $cat_id;
        // $articles->user_id = $userId;
        // R::store($articles);
    }

    R::close();
}else{
//     //Do whatever you want
    
}

