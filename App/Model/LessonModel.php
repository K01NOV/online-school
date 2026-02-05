<?php namespace App\Model;

use PDO;
use App\Entity\LessonEntity;

class LessonModel{
    private $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }

    public function get_lessons(int $topic_id){
        $sql = "SELECT * FROM lessons WHERE topic_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $topic_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lessons = [];

        foreach($rows as $row){
            $lessons[] = new LessonEntity(
                $row['id'],
                $row['title'],
                $row['topic_id']
            );
        }

        return $lessons;
    }

}