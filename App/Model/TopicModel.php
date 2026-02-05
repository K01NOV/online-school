<?php namespace App\Model;

use PDO;
use App\Entity\TopicEntity;

class TopicModel{
    private $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }

    public function get_topics(int $subject_id){
        $sql = "SELECT * FROM topics WHERE subject_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row){
            $topics[] = new TopicEntity(
                $row['id'],
                $row['title'],
                $row['subject_id']
            );
        }
        return $topics;
    }
}