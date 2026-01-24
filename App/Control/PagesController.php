<?php namespace App\Control;

class PagesController{
    function __construct($db){}
    function showHome(){
        require_once __DIR__ . "/../../View/home.php";
    }

    function showRegistration(){
        require_once __DIR__ . "/../../View/register.php";
    }

    function showProfile(){
        require_once __DIR__ . "/../../View/userRoom.php";
    }
    function userRoom(){
        $name = $_SESSION['name'] ?? 'Guest'; 
        require_once __DIR__ . '/../../View/userRoom.php';
    }
}