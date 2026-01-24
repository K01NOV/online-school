<?php namespace App\Model;

class UserEntity{
    public $name;
    public $email;
    public $type;
    public $nick;
    public $password;

    public function __construct($name, $email, $password, $type, $nick){
        $this->name = $this->name_validation($name);
        $this->email = $this->email_validation($email);
        $this->password = $this->password_validation($password);
        $this->nick = $this->nickname_validation($nick);
        $this->type = $this->type_validation($type);
    }

    public function name_validation($name){
        $name = trim($name);
        if(mb_strlen($name) < 2){
            throw new \Exception("Имя слишком корокое: " . $name);
        }
        $pattern = '/[^\p{L}\s]/u'; 
        if(preg_match($pattern, $name)){
            throw new \Exception("Имя не может содержать цифры или спец. символы: " . $name);
        }
        return mb_strimwidth($name, 0, 30);
    }

    public function password_validation($password){
        if(mb_strlen($password) < 8){
            throw new \Exception("Пароль должен содержать хотя бы 8 символов");
        }
        if(mb_strlen($password) > 100){
            throw new \Exception("Пароль не может содержать более 100 символов");
        }
        return $password;
    }

    public function email_validation($email){
        $email = trim($email);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \Exception("Неверно указана почта: " . $email);
        }
        return $email;
    }

    public function type_validation($type){
        $allowedTypes = [
            'personal' => 'Личный аккаунт',
            'student'  => 'Ученик',
            'teacher'  => 'Учитель',
            'parent'   => 'Родитель'
        ];

        $key = array_search($type, $allowedTypes);

        if ($key === false) {
            throw new \Exception("Возникла ошибка связанная с типом аккаунта, попробуйте еще раз: " . $type);
        }
        return $key;
    }

    public function nickname_validation($nick){
        $nick = trim($nick);
        $pattern = '/[\s#]/u';
        if(mb_strlen($nick) < 2){
            throw new \Exception("Никнейм слишком короткий: " . $nick);
        }
        if(mb_strlen($nick) > 30){
            throw new \Exception("Никнейм слишком длинный: " . $nick);
        }
        if(preg_match($pattern, $nick)){
            throw new \Exception("Никнейм не может содержать знак # или пробел: " . $nick);
        }
        return $nick;
    }


}