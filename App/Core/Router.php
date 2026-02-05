<?php namespace App\Core;

use App\Control\UserController;
use App\Control\PagesController;
use App\Control\SubjectController;

use PDO;
use PDOException;

class Router{

    private $conn;
   private $routes = [
        '' => [PagesController::class, 'showHome'],
        'home' => [PagesController::class, 'showHome'],
        'registration' => [PagesController::class, 'showRegistration'],
        'register' => [UserController::class, 'createUser'],
        'dashboard' => [SubjectController::class, 'display_subjects'],
        'login' => [UserController::class, 'login'],
        'logout' => [UserController::class, 'logout'],
        'subject-info' => [SubjectController::class, 'subject_info'],
        'lesson' => [PagesController::class, 'showLesson']
    ];

    function __construct(){
        session_start();
        require_once __DIR__ . '/../Config/DataBase.php';
        try{
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Чтобы ошибки SQL были видны
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Чтобы данные возвращались массивами
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Для безопасности (защита от инъекций)
            ]);
        } catch (PDOException $e) {
            die("Ошибка подключения к БД: " . $e->getMessage());
        }
    }

    public function run($route){
        if(array_key_exists($route, $this->routes)){
            $controlName = $this->routes[$route][0];
            $method = $this->routes[$route][1];
            $controller = new $controlName($this->conn);
            $controller->$method();
        }
        else{
            header("HTTP/1.0 404 Not Found");
            echo "404 - Страница не найдена на royal-academy.lt";
        }
    }
}