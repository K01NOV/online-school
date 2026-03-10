<?php namespace App\Control;

use App\Model\CrudModel;

class CrudController{
    private $conn;
    private $crudModel;

    public function __construct($db){
        $this->conn = $db;
        $this->crudModel = new CrudModel($this->conn);
    }

    public function show_crud(){
        $tables = $this->crudModel->get_all_tables();
        if(isset($_GET['table'])){
            $columns = $this->crudModel->get_columns($_GET['table']);
            $data = $this->crudModel->get_data($_GET['table']);
        }
        require_once __DIR__ . '/../../View/admin_head.php';
        require_once __DIR__ . '/../../View/admin_crud.php';
        require_once __DIR__ . '/../../View/footer.php';
    }
}