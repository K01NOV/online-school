<?php namespace App\Control;

use App\Model\UserEntity;
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
                    throw new \Exception("Этот email уже занят: " . $this->userEntity->email);
                }
                $_SESSION['name'] = $this->userEntity->name;
                if (!$this->userModel->createUser($this->userEntity)) {
                    throw new \Exception("Не удалось создать профиль, попробуйте еще раз");
                }
                header("Location: /profile");
                exit();

            } catch(\Exception $e){
                $_SESSION['error'] = $e->getMessage();
                header("Location: /registration");
                exit();
            }


            //
            //if($this->userModel->createUser($name, $email, $type, $password, $nick)){
            //    header("Location: /profile");
            //    exit();
            //}
            //header("Location: /error");
            //exit();
        }
    }
    function userRoom(){
        $name = $_SESSION['name'] ?? 'Guest'; 
        require_once __DIR__ . '/../../View/userRoom.php';
    }
}