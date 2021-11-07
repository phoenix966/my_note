<?php

require __DIR__.'/../config/db.php';


if(isset($_POST['updateKey'])){
  $updateId = $_POST['updateKey'];
  $title = $_POST['title'];
  $text = $_POST['text'];
  $cat = $_POST['cat_id'];
  $new_cat = $_POST['new_cat'];

   //Получение userID
    $userId = -1;
    
    if(isset($_COOKIE['user'])){
      $user_pass_hash = $_COOKIE['user'];
      $user_data = R::findOne('users','hash = ?',[$user_pass_hash]);
      $userId = $user_data['id'];  
   }
     
    // Обновление записи
  if(isset($new_cat)){
    R::exec('INSERT INTO articles_categories (categorie_title,user_id) VALUES (?,?)',[$new_cat,$userId]);
    $new_cat_id = R::findOne('articles_categories','categorie_title = ? AND user_id = ?',[$new_cat,$userId]);
    $id = $new_cat_id['id'];
    R::exec('UPDATE articles SET title = ?, text = ?,categorie_id = ? WHERE id = ? AND user_id = ?',[$title,$text,$id,$updateId,$userId]);
  }else{
    R::exec('UPDATE articles SET title = ?,text = ?,categorie_id = ? WHERE id = ? AND user_id = ?',[$title,$text,$cat,$updateId,$userId]);
  }
  R::close();
} else{
  //Что то выведешь!
}