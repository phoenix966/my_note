<?php

include('../config/db.php');

$result = $_GET['tempId'];

if(isset($result)){
  mysqli_query($connection,"DELETE FROM `temp_cat_id`");
  mysqli_query($connection,"INSERT INTO `temp_cat_id` (`id`) VALUES ('$result')");
}else{
  
}