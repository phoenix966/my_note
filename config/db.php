<?php
require_once("config.php");

$connection = mysqli_connect($config['db']['url'], $config['db']['login'], $config['db']['pass'], $config['db']['name']);

if ($connection == false) {
    echo 'не удалось подключится к базе данных!<br>';
    echo mysqli_connect_error();
    exit();
};

