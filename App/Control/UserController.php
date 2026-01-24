<?php namespace App\Control;

use App\Model\UserEntity;
use Exception;
use PDO;
use App\Model\UserModel;

class UserController{
    private $conn;
    private $userModel;
    private $userEntity;

    function __construct(PDO $db){
        $this->conn = $db;
        $this->userModel = new UserModel($this->conn);
    }

    function createUser(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try{
                $this->userEntity = new UserEntity(
                    $_POST['name'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['account_type'],
                    $_POST['nick']
                );

                if($this->userModel->check_email_existance($this->userEntity->email)){
                    throw new Exception("Этот email уже занят: " . $this->userEntity->email);
                }
                if (!$this->userModel->createUser($this->userEntity)) {
                    throw new Exception("Не удалось создать профиль, попробуйте еще раз");
                }
                //$info = $this->userModel->get_user_password($_POST['email']);
                $_SESSION['name'] = $this->userEntity->name;
                //$_SESSION['id'] = $info['id'];
                //$info = null;
                header("Location: /profile");
                exit();

            } catch(Exception $e){
                $_SESSION['error'] = $e->getMessage();
                header("Location: /registration");
                exit();
            }
        }
    }

    function login(){
        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            try{
                $info = $this->userModel->get_user_password($_POST['login']);
                if($info && password_verify($_POST['password'], $info['password'])){
                    $_SESSION['name'] = $info['name'];
                    $_SESSION['id'] = $info['id'];
                    $info = null;
                    header("Location: /profile");
                    exit();
                }
                throw new Exception("Неверный логин или пароль");
            } catch(Exception $e){
                $_SESSION['error'] = $e->getMessage();
                header("Location: /registration");
                exit();
            }
        }
    }
    
    function userRoom(){
        $name = $_SESSION['name'] ?? 'Guest'; 
        require_once __DIR__ . '/../../View/userRoom.php';
    }
}