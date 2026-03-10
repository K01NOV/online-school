<?php namespace App\Control;

class DashboardController{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function show_dashboard(){
        require_once __DIR__ . '/../../View/admin_head.php';
        require_once __DIR__ . '/../../View/admin_dashboard.php';
    }
}