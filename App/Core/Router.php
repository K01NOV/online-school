<?php namespace App\Core;

use App\Control\MainControl;
use App\Control\UserControl;
class Router{

   private $routes = [
        '' => [MainControl::class, 'index'],
        'home' => [MainControl::class, 'index'],
        'register' => [UserControl::class, 'register']
    ];

    public function run($route){
        if(array_key_exists($route, $this->routes)){
            $controlName = $this->routes[$route][0];
            $method = $this->routes[$route][1];

            $controller = new $controlName();
            $controller->$method();
        }
        else{
            header("HTTP/1.0 404 Not Found");
            echo "404 - Страница не найдена на royal-academy.lt";
        }
    }
}