<?php namespace App\Core;

class Security{
    public static function generate_token(){
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true); 
        }
        $_SESSION['auth_token'] = bin2hex(random_bytes(32));
        return $_SESSION['auth_token'];
    }

    public static function check_token($token){
        return isset($_SESSION['auth_token']) && hash_equals($_SESSION['auth_token'], $token);
    }
}