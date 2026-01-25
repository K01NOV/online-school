<?php namespace App\Control;

class PagesController{
    function __construct($db){}
    function showHome(){
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . "/../../View/home.php";
        require_once __DIR__ . "/../../View/footer.php";
    }

    function showRegistration(){
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . "/../../View/register.php";
        require_once __DIR__ . "/../../View/footer.php";
    }

    function showProfile(){
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . "/../../View/dashboard.php";
        require_once __DIR__ . "/../../View/footer.php";
    }
    function showDashboard(){
        $name = $_SESSION['name']; 
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . '/../../View/dashboard.php';
        require_once __DIR__ . "/../../View/footer.php";
    }
}