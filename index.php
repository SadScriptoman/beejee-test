<?php

    ini_set('display_errors', 1);

    if (file_exists('app/bootstrap.php')){
        require_once 'app/bootstrap.php';
    }else{
        echo 'Файла app/bootstrap.php не существует!<br>';
    }