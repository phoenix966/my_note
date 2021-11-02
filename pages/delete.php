<?php

require __DIR__.'/../config/db.php';

if(isset($_GET['removeKey'])){
  $removeId = $_GET['removeKey'];
  $articles = R::load('articles',$removeId); //ok
  R::trash($articles);
  R::close();
} else{
  //Что то выведешь!
};