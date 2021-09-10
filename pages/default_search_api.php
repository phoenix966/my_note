<?php

include('../config/db.php');

if(isset($_GET['isTrue'])){
	$result_temp = mysqli_query($connection,"SELECT `title`,`id` FROM `articles`");
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
