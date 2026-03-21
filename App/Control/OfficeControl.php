<?php namespace App\Control;

use App\Control\CrudController;
use App\Control\DashboardController;
class OfficeControl{
    private $conn;
    private $routes = [
        'dashboard' => [DashboardController::class, 'show_dashboard'],
        'crud' => [CrudController::class, 'show_crud'],
        'subjects' => [SubjectEditController::class, 'show_editor'],
    ];
    public function __construct($db){
        $this->conn = $db;
    }

    public function run_admin(){
        if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
            header("Location: /"); 
            exit();
        }
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $uri);
        $routeKey = (isset($parts[1]) && $parts[1] !== '') ? $parts[1] : 'dashboard';
        if(!array_key_exists($routeKey, $this->routes)){
            throw new \Exception("Страница не найдена: " . $routeKey, 404);
        }
        $route = $this->routes[$routeKey];
        $class = $route[0];
        $method = $route[1];
        $controller = new $class($this->conn);
        $controller->$method();
    }
}