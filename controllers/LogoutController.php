<?php


class LogoutController{

    public function __construct(){

    }

    public function run(){

        $_SESSION = array();
        header("Location: index.php?action=accueil");
        die();
    }
}