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

    function showAdmin(){
        require_once __DIR__ . "/../../View/admin_head.php";
        require_once __DIR__ . "/../../View/admin_crud.php";
        require_once __DIR__ . "/../../View/footer.php";
    }
    function showLesson(){
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . '/../../View/lessonSample.php';
        require_once __DIR__ . "/../../View/footer.php";
    }
}