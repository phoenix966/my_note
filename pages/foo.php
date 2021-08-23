<?php

//$_GET
//$_POST

// print_r($_POST);

$connection = mysqli_connect('localhost:8889','root','root','note_db');

if($connection == false){
	echo 'не удалось подключится к базе данных!<br>';
	echo mysqli_connect_error();
	exit();
}

// $result = mysqli_query($connection,"SELECT * FROM `articles_categories`");

// $r1 = mysqli_fetch_assoc($result);

// print_r($r1);
if(isset($_POST['title'])){
    //Do whatever you want
    $title = $_POST['title'];
    $text = $_POST['text'];
    $cat_id = $_POST['cat_id'];
    $new_cat = $_POST['new_cat'];
    if(isset($new_cat)){
        mysqli_query($connection,"INSERT INTO `articles_categories` (`categorie_title`) VALUES ('$new_cat') ");

        $temp = mysqli_query($connection,"SELECT `id` FROM `articles_categories` WHERE `categorie_title` = '$new_cat' ");
        $new_cat_id = mysqli_fetch_assoc($temp);
        $id = $new_cat_id['id'];
        mysqli_query($connection,"INSERT INTO `articles`  (`title`,`text`,`categorie_id`) VALUES ('$title','$text','$id')");
    }else{
        mysqli_query($connection,"INSERT INTO `articles`  (`title`,`text`,`categorie_id`) VALUES ('$title','$text','$cat_id')");
    }
    mysqli_close($connection);  
}else{
    //Do whatever you want
    
};

