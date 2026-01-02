<?php
require_once '../vendor/autoload.php';

use App\Core\Router;

$route = $_GET['route'] ?? '';

$router = new Router();
$router->run($route);