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
        $tables = $this->get_all_tables();
        if(!in_array($table, $tables)){
            throw new \Exception("Таблица не найдена: " . $table);
        }
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
        $tables = $this->get_all_tables();
        if(!in_array($table, $tables)){
            throw new \Exception("Таблица не найдена: " . $table);
        }
        $sql = "SELECT DISTINCT * FROM `$table`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function delete_row($table, int $id){
        $tables = $this->get_all_tables();
        if(!in_array($table, $tables)){
            throw new \Exception("Таблица не найдена: " . $table);
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
        $tables = $this->get_all_tables();
        if (!in_array($table, $tables)) {
            throw new \Exception("Таблица не найдена", 404);
        }

        if (empty($data)) {
            throw new \Exception("Недостаточно данных", 400);
        }

        $columns = array_keys($data);
        $realColumns = $this->get_columns($table);
        $insertData = [];
        foreach ($realColumns as $colName => $colInfo) {
            if ($colName != 'id'){
                $insertData[$colName] = $data[$colName] ?? '';
            }
        }
        $columns = array_keys($insertData);
        $colString = implode(", ", array_map(function($col){ return "`$col`"; }, $columns));
        $placeholders = ":" . implode(", :", $columns);
        $sql = "INSERT INTO `$table` ($colString) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Возвращаем id
        }

        throw new \Exception("Ошибка при вставке данных", 500);
    }

    public function update_at($table, $column, $value, $id){
        $tables = $this->get_all_tables();
        if (!in_array($table, $tables)) {
            throw new \Exception("Таблица не найдена");
        }

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
}