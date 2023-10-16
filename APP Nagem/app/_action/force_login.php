<?php

session_start();

if(!isset($_SESSION["login"])){
    header("location: /");
    exit();
}

if(empty($_SESSION["login"]["logged"]) || $_SESSION["login"]["login"] != true){
    session_unset();    
    session_destroy();

    header("location: /");
    exit();
}

$login = $_SESSION["login"]["login"];