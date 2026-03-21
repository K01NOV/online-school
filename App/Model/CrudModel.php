<?php namespace App\Model;

use PDO;
use Exception;
class CrudModel{
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }

    public function get_all_tables(){
        $sql = "SHOW TABLES FROM online_school";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tables = [];
        foreach($rows as $row){
            $tables[] = $row['Tables_in_online_school'];
        }
        return $tables;
    }

    public function get_columns($table){
        $this->validate_table($table);
        $sql = "SHOW COLUMNS FROM online_school.`$table`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $columns = [];
        foreach($rows as $row){
            $field = $row['Field'];
            $rawType = $row['Type']; 

            if (str_contains($rawType, 'int')) {
                $type = "number";
            } elseif (str_contains($rawType, 'date')) {
                $type = "date";
            } else {
                $type = "text";
            }

            $columns[$field] = [
                'type' => $type,
                'required' => ($row['Null'] === "NO") ? "required" : "",
                'disabled' => ($row['Extra'] === 'auto_increment') ? "disabled" : ""
            ];
        }

        return $columns;
    }

    public function get_data($table){
        $this->validate_table($table);
        $sql = "SELECT DISTINCT * FROM `$table`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function delete_row($table, int $id){
        $this->validate_table($table);
        if ($id <= 0){
            throw new \Exception("Некорректный ID", 400);
        } 
        $sql = "DELETE FROM `$table` WHERE `$table`.`id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }
        
        throw new \Exception("Возникла ошибка при удалении");
    }

    public function insert_into($table, $data){
        $this->validate_table($table);

        if (empty($data)) {
            throw new \Exception("Недостаточно данных", 400);
        }

        $columns = array_keys($data);
        $realColumns = $this->get_columns($table);
        $insertData = [];
        foreach ($realColumns as $colName => $colInfo) {
            if ($colName != 'id'){
                $insertData[$colName] = $data[$colName] ?? $this->get_default_value($colInfo['type']);
            }
        }
        $columns = array_keys($insertData);
        $colString = implode(", ", array_map(function($col){ return "`$col`"; }, $columns));
        $placeholders = ":" . implode(", :", $columns);
        $sql = "INSERT INTO `$table` ($colString) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($insertData)) {
            return $this->conn->lastInsertId(); // Возвращаем id
        }

        throw new \Exception("Ошибка при вставке данных", 500);
    }

    public function update_at($table, $column, $value, $id){
        $this->validate_table($table);

        $realColumns = $this->get_columns($table);
        if(!array_key_exists($column, $realColumns)){
            throw new \Exception("Столбец не найден: $column");
        }

        $sql = "UPDATE $table SET $column = :new WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":new", $value);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }
        throw new \Exception("Не удалось обновить значение: $column = $value");
    }

    private function get_default_value($type){
        switch($type){
            case 'number':
                return 0;
            case 'date':
                return date('Y-m-d');
            default:
                return '';
        }
    }

    public function create_column($table, $columnName, $params){
        $this->validate_table($table);
        $constrains = $this->generate_constrains($params);
        $sql = "ALTER TABLE `$table` ADD `$columnName` $constrains";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            return true;
        }
        throw new \Exception("Не удалось создать колонку: $columnName");
    }

    private function validate_table($table){
        $tables = $this->get_all_tables();
        if (!in_array($table, $tables)) {
            throw new \Exception("Таблица не найдена");
        }
        return true;
    }

    private function generate_constrains($params){
        // $params = ['type' => 'VARCHAR(255)', 'is_null' => false, 'default' => 'No title', 'is_unique' => false, 'is_ai' => false];
        $constraints[] = $params['type'] ?? 'VARCHAR(255)';
        if (!empty($params['is_primary'])) {
            $constraints[] = 'NOT NULL';
            $constraints[] = "PRIMARY KEY";
        }
        if(isset($params['is_null']) && !in_array('NOT NULL', $constraints)){
            $constraints[] = $params['is_null'] ? 'NULL' : 'NOT NULL';
        }
        if (isset($params['default']) && $params['default'] !== '') {
            $default = $params['default'];
            $constraints[] = "DEFAULT " . ($this->is_number($params['type']) ? $default : "'$default'");
        }
        if (!empty($params['is_unique'])) {
            $constraints[] = "UNIQUE";
        }
        if (!empty($params['is_ai'])) {
            $constraints[] = "AUTO_INCREMENT";
        }
        return implode(' ', $constraints);
    }

    private function is_number($type) {
        $type = strtolower($type);
        return strpos($type, 'int') !== false || strpos($type, 'decimal') !== false || strpos($type, 'float') !== false;
    }

    public function change_column_name(){

    }
}