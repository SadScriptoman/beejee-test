<?php

    $Application = NULL;

    if (file_exists('app/core/model.php')){
        require_once 'app/core/model.php';
    }else{
        echo 'Файла core/model.php не существует!<br>';
    }

    if (file_exists('app/core/view.php')){
        require_once 'app/core/view.php';
    }else{
        echo 'Файла core/view.php не существует!<br>';
    }

    if (file_exists('app/core/controller.php')){
        require_once 'app/core/controller.php';
    }else{
        echo 'Файла core/controller.php не существует!<br>';
    }

    if (file_exists('app/core/application.php')){
        require_once 'app/core/application.php';
    }else{
        echo 'Файла core/application.php не существует!<br>';
    }

    if (file_exists('app/core/buffer.php')){
        require_once 'app/core/buffer.php';
    }else{
        echo 'Файла core/buffer.php не существует!<br>';
    }

    $Application = new Application();


