<?php namespace App\Control;

use App\Control\CrudController;
use App\Control\DashboardController;
class OfficeControl{
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }

    public function run_admin(){
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $uri);
        $subPage = $parts[1] ?? 'dashboard';

        switch($subPage){
            case 'crud':
                $controller = new CrudController($this->conn);
                $controller->show_crud();
                break;
            case 'dashboard':
                $controller = new DashboardController($this->conn);
                $controller->show_dashboard();
                break;
            
        }
    }
}