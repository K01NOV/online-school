<?php namespace App\Control;

use App\Entity\UserEntity;
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
                $info = $this->userModel->get_user_data($_POST['email']);
                $_SESSION['name'] = $info['name'];
                $_SESSION['id'] = $info['id'];
                $_SESSION['email'] = $info['mail'];
                $_SESSION['type'] = $info['type'];
                if(!empty($info['nickname'])){
                    $_SESSION['nickname'] = $info['nickname'];
                }
                $info = null;
                header("Location: /dashboard");
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
                $info = $this->userModel->get_user_data($_POST['login']);
                if($info && password_verify($_POST['password'], $info['password'])){
                    $_SESSION['name'] = $info['name'];
                    $_SESSION['id'] = $info['id'];
                    $_SESSION['email'] = $info['mail'];
                    $_SESSION['type'] = $info['type'];
                    if(!empty($info['nickname'])){
                        $_SESSION['nickname'] = $info['nickname'];
                    }
                    $info = null;
                    header("Location: /dashboard");
                    exit();
                }
                throw new Exception("Неверный логин или пароль (хз короч)");
            } catch(Exception $e){
                $_SESSION['error'] = $e->getMessage();
                header("Location: /registration");
                exit();
            }
        }
    }

    function logout(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();
            session_unset();
            session_destroy();
            header("Location: /registration");
            exit();
        }
    }
}