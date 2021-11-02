<?php

require __DIR__.'/../config/db.php';

if(isset($_GET['isTrue'])){
	//Получение userID
	$userId = -1;

    if(isset($_COOKIE['user'])){

       	  $user_pass_temp = $_COOKIE['user'];
		  $user_data = R::findOne('users','pass = ?',[$user_pass_temp]);   //ok
		  $userId = $user_data['id'];
    }

	$result_temp = R::getAll('SELECT `title`,`id` FROM `articles` WHERE `user_id` = ?',[$userId]); //ok
	$result_temp_count = count($result_temp);

	$arr = [];
	if($result_temp_count == 0){
		
	}else{
		foreach($result_temp as $item){ //ok
			array_push($arr,$item);
		}
	}
	}
	$json = json_encode($arr);
	echo $json;
	R::close();

