<?php namespace App\Control;

use Api\TableApi;
class ApiControl{
    private $conn;
    private $routes = [
        'table' => TableApi::class,
    ];
    public function __construct($db){
        $this->conn = $db;
    }

    public function run_api(){
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $uri);
        $apiClass = $parts[1];
        if(!array_key_exists($apiClass, $this->routes)){
            http_response_code(404);
            echo json_encode(['error' => 'API маршрут не найден']);
            return;
        }
        $apiClass = $this->routes[$apiClass];
        $method = $parts[2];
        $api = new $apiClass($this->conn);
        if (method_exists($api, $method)) {
            $api->$method();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Метод не найден']);
        }
        exit();
    }
}