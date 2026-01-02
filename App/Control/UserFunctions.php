<?php namespace App\Control;
session_start();
class UserFunctions{
    function createUser(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name = $_POST['name'] ?? 'Guest';
            

            $_SESSION['name'] = $name;
            header("Location: /profile");
            exit();
        }
    }
    function userRoom(){
        $name = $_SESSION['name'] ?? 'Guest'; 
        require_once __DIR__ . '/../../View/userRoom.php';
    }
}