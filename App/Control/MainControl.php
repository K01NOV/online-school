<?php namespace App\Control;

class MainControl{
    public function index(){
        require_once __DIR__ . "/../../View/home.php";
    }
}