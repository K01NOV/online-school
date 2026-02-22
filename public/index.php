<?php
require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

use App\Core\Router;

$route = $_GET['route'] ?? '';

$router = new Router();
$router->run($route);
//test