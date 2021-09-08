<?php

include('../config/db.php');

if(isset($_GET['removeKey'])){
  $removeId = $_GET['removeKey'];
  mysqli_query($connection,"DELETE FROM `articles` WHERE `id` = '$removeId' ");
  mysqli_close($connection);
} else{
  //Что то выведешь!
};