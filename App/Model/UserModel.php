<?php namespace App\Model;

use Exception;
use PDO;

class UserModel{
    private $conn;
    function __construct(PDO $db){
        $this->conn = $db;
    }

    function createUser($user){
        try{
            $this->conn->beginTransaction();
            $hash = password_hash($user->password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO user (name, mail, password, type) VALUES (:name, :email, :password, :type)");
            $stmt->bindValue(":name", $user->name);
            $stmt->bindValue(":email", $user->email);
            $stmt->bindValue(":password", $hash);
            $stmt->bindValue(":type", $user->type);

            if(!$stmt->execute()){
                throw new Exception("Не удалось создать пользователя, попробуйте еще раз");
            }

            if(!empty($user->nick)){
                $userId = $this->conn->lastInsertId();
                if (!$userId){
                    throw new Exception("Не удалось найти id, попробуйте еще раз");
                } 

                $user->nick = $this->create_nickname($user->nick);
                if(!$user->nick){
                    throw new Exception("Не удалось зарегистрировать ваш никнейм: " . $user->nick);
                }

                $stmt = $this->conn->prepare("INSERT INTO usernames (user_id, title) VALUES (:id, :nick)");
                $stmt->bindParam(':id', $userId);
                $stmt->bindParam(':nick', $user->nick);

                $stmt->execute();
            }

            
            $this->conn->commit();
            return true;

        }catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            
            error_log("Ошибка создания пользователя: " . $e->getMessage());
            return false; 
        }
    }

    function check_email_existance($email){
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE mail = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $users = $stmt->fetchAll();
        if(count($users) > 0){
            return true;
        }
        return false;
    }

    public function create_nickname($nick) {
        if (!$nick) return false;
        $temp = $nick . '#%';

        //UNSIGNED это int без знака
        $sql = "SELECT CAST(SUBSTRING_INDEX(title, '#', -1) AS UNSIGNED) as tag FROM usernames WHERE title LIKE :pattern ORDER BY tag ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pattern', $temp);
        $stmt->execute();
        
        $usedTags = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $nextTag = 1;
        foreach ($usedTags as $tag) {
            if ($tag == $nextTag) {
                $nextTag++;
            } else {
                break; 
            }
        }

        if ($nextTag > 9999) return false;

        return $nick . "#" . str_pad($nextTag, 4, "0", STR_PAD_LEFT);
    }

    public function get_user_data($user){
        if(!$user){
            throw new Exception("Неверный логин или пароль (нет данных)");
        }
        $sql = "SELECT user.id, name, password, usernames.title AS nickname, user.mail, user.type FROM user LEFT JOIN usernames ON usernames.user_id = user.id WHERE usernames.title = :user1 OR user.mail = :user2";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user1', $user);
        $stmt->bindParam(':user2', $user);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(empty($userData)){
            throw new Exception("Неверный логин или пароль (нет пароля)");
        }

        return $userData;
    }

}