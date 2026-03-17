<?php namespace Api;

use App\Core\Security;
use App\Model\CrudModel;
use Exception;

class TableApi{
    private $conn;
    private $crudModel;
    public function __construct($db){
        $this->conn = $db;
        $this->crudModel = new CrudModel($this->conn);
    }

    public function update(){
        header('Content-Type: application/json');
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Ошибка метода", 405);
            }
            
            $input = json_decode(file_get_contents('php://input'));
            $token = $input->token ?? null;
            $this->who_is($token);
            $table = $input->table ?? null;
            $id = $input->id ?? null;
            $column = $input->column ?? null;
            $value = $input->value ?? '';
            if(!$table || !$id ||!$column){
                throw new \Exception("Отсутствуют обязательные параметры");
            }

            $result = $this->crudModel->update_at($table, $column, $value, $id);
            if(!$result){
                throw new \Exception("Не удалось обновить данные", 400);
            }
            echo json_encode(['success' => true, 'message' => 'Обновлено']);
            exit();
        } catch(Exception $e){
            $rawCode = $e->getCode();
            $code = (is_numeric($rawCode) && $rawCode >= 100 && $rawCode < 600) ? (int)$rawCode : 500;
            http_response_code($code);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $code
            ]);
            exit();
        }
    }

    public function delete(){
        header('Content-Type: application/json');
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Ошибка метода", 405);
            }
            $input = json_decode(file_get_contents('php://input'));
            $token = $input->token ?? null;
            $this->who_is($token);
            $table = $input->table ?? null;
            $id = $input->id ?? null;

            if(!$table || !$id){
                throw new \Exception("Отсутствуют обязательные параметры");
            }
            $result = $this->crudModel->delete_row($table, $id);
            if(!$result){
                throw new \Exception("Не удалось удалить данные", 400);
            }
            echo json_encode(['success' => true, 'message' => 'Запись успешно удалена']);
            exit();
        } catch(\Exception $e){
            $rawCode = $e->getCode();
            $code = (is_numeric($rawCode) && $rawCode >= 100 && $rawCode < 600) ? (int)$rawCode : 500;
            http_response_code($code);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $code
            ]);
            exit();
        }
    }

    public function insert(){
        header('Content-Type: application/json');
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Ошибка метода", 405);
            }
            $input = json_decode(file_get_contents('php://input'));
            $token = $input->token ?? null;
            $this->who_is($token);
            $table = $input->table ?? null;
            $data = (array) $input->data ?? null;

            if(!$table || !$data){
                throw new \Exception("Отсутствуют обязательные параметры");
            }
            $result = $this->crudModel->insert_into($table, $data);
            if(!$result){
                throw new \Exception("Не удалось вставить данные", 400);
            }
            echo json_encode(['success' => true, 'message' => 'Запись успешно вставлена', 'id' => $result]);
            exit();
        } catch(\Exception $e){
            $rawCode = $e->getCode();
            $code = (is_numeric($rawCode) && $rawCode >= 100 && $rawCode < 600) ? (int)$rawCode : 500;
            http_response_code($code);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => $code
            ]);
            exit();
        }
    }

    private function who_is($token){
        if(!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin'){
            throw new \Exception("У вас нет прав на вызов этой команды", 401);
        }
        if(!Security::check_token($token)){
            throw new \Exception("У вас нет прав на вызов этой команды", 401);
        }
        return true;
    }
}