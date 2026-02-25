<?php namespace App\Entity;

use App\Enum\UserType;
class UserEntity{
    public $name;
    public $email;
    public UserType $type;
    public $nick;
    public $password;

    public function __construct($name, $email, $password, UserType $type, $nick){
        $this->name = $this->name_validation($name);
        $this->email = $this->email_validation($email);
        $this->password = $this->password_validation($password);
        $this->type = $type;
        $this->nick = $this->nickname_validation($nick);
    }

    public function name_validation($name){
        $name = trim($name);
        if(mb_strlen($name) < 2){
            throw new \InvalidArgumentException("Имя слишком корокое: " . $name);
        }
        $pattern = '/[^\p{L}\s]/u';
        if(preg_match($pattern, $name)){
            throw new \InvalidArgumentException("Имя не может содержать цифры или спец. символы: " . $name);
        }

        return mb_strimwidth($name, 0, 70);
    }

    public function password_validation($password){
        if(mb_strlen($password) < 8){
            throw new \InvalidArgumentException("Пароль должен содержать хотя бы 8 символов");
        }
        if(mb_strlen($password) > 100){
            throw new \InvalidArgumentException("Пароль не может содержать более 100 символов");
        }
        return $password;
    }

    public function email_validation($email){
        $email = trim($email);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Неверно указана почта: " . $email);
        }
        return $email;
    }

    public function nickname_validation($nick){
        $nick = trim($nick);
        $pattern = '/[\s#]/u';
        if(mb_strlen($nick) < 2 && ($this->type == UserType::Personal || $this->type == UserType::Student)){
            throw new \InvalidArgumentException("Никнейм слишком короткий: " . $nick);
        }
        if(mb_strlen($nick) > 30){
            throw new \InvalidArgumentException("Никнейм слишком длинный: " . $nick);
        }
        if(preg_match($pattern, $nick)){
            throw new \InvalidArgumentException("Никнейм не может содержать знак # или пробел: " . $nick);
        }
        return $nick;
    }


}