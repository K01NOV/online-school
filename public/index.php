<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();
session_start();
use App\Core\Router;

$route = $_GET['route'] ?? '';

$publicRoutes = ['home', 'registration', 'register', 'login', '']; 

if (!in_array($route, $publicRoutes) && !isset($_SESSION['id'])) {
    header("Location: /registration");
    exit();
} else{
    $router = new Router();
    $router->run($route);
}

