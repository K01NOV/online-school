<?php namespace App\Control;

class CrudController{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function show_crud(){
        require_once __DIR__ . '/../../View/admin_head.php';
        require_once __DIR__ . '/../../View/admin_crud.php';
    }
}