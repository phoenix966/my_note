<?php

include('../config/db.php');

if(isset($_GET['isTrue'])){

	//Получение userID
	$userId = -1;
	
    if(isset($_COOKIE['user'])){

       $user_pass_temp = $_COOKIE['user'];
       $current_user_data_temp = mysqli_query($connection,"SELECT * FROM `users` WHERE  `pass` = '$user_pass_temp'");
       $user_data = mysqli_fetch_assoc($current_user_data_temp);
       $userId = $user_data['id'];  
    }

	$result_temp = mysqli_query($connection,"SELECT `title`,`id` FROM `articles` WHERE `user_id` = '$userId' ");
	$arr = [];
	if(mysqli_num_rows($result_temp) == 0){
		
	}else{
	  while($item = mysqli_fetch_assoc($result_temp)){
		array_push($arr,$item);
	}
	}
	$json = json_encode($arr);
	echo $json;
	mysqli_close($connection);
}
