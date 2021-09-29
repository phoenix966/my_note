<?php

include('../config/db.php');

if(isset($_POST['title'])){

    $title = $_POST['title'];
    $text = $_POST['text'];
    $cat_id = $_POST['cat_id'];
    $new_cat = $_POST['new_cat'];

    $userId = -1;

    //Получение userID

    if(isset($_COOKIE['user'])){

       $user_pass_temp = $_COOKIE['user'];
       $current_user_data_temp = mysqli_query($connection,"SELECT * FROM `users` WHERE  `pass` = '$user_pass_temp'");
       $user_data = mysqli_fetch_assoc($current_user_data_temp);
       $userId = $user_data['id'];  
    }
     
    // Логика создания записи

    if(isset($new_cat)){
        mysqli_query($connection,"INSERT INTO `articles_categories` (`categorie_title`,`user_id`) VALUES ('$new_cat','$userId') ");

        $temp = mysqli_query($connection,"SELECT `id` FROM `articles_categories` WHERE `categorie_title` = '$new_cat' AND `user_id` = '$userId' ");
        $new_cat_id = mysqli_fetch_assoc($temp);
        $id = $new_cat_id['id'];
        mysqli_query($connection,"INSERT INTO `articles`  (`title`,`text`,`categorie_id`,`user_id`) VALUES ('$title','$text','$id','$userId')");
    }else{
        mysqli_query($connection,"INSERT INTO `articles`  (`title`,`text`,`categorie_id`,`user_id`) VALUES ('$title','$text','$cat_id','$userId')");
    }
    mysqli_close($connection); 
}else{
    //Do whatever you want
    
}

