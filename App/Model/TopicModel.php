<?php namespace App\Model;

use PDO;
use Exception;
use App\Entity\TopicEntity;

class TopicModel{
    private $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }

    public function get_all(int $subject_id){
        $sql = "SELECT * FROM topics WHERE subject_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $topics = [];

        foreach($rows as $row){
            $topics[] = new TopicEntity(
                $row['id'],
                $row['title'],
                $row['subject_id']
            );
        }
        return $topics;
    }

    public function sort_wide($class, int $subject){
        $classes = ['1-4', '5-9', '10-11'];
        if(!in_array($class, $classes)){
            return [];
        }

        switch($class){
            case '1-4':
                $class = 12;
                break;
            case '5-9':
                $class = 13;
                break;
            case '10-11':
                $class = 14;
                break;
            default:
                $class = 12;
                break;
        }

        $sql = "SELECT DISTINCT
            topics.id AS topic_id, 
            topics.subject_id,
            topics.title AS topic_title, 
            `topic-class`.class_id, 
            more_classes.grouped_class_id, 
            more_classes.title AS class_title
        FROM topics
        JOIN `topic-class` ON topics.id = `topic-class`.topic_id
        JOIN more_classes ON `topic-class`.class_id = more_classes.id WHERE more_classes.grouped_class_id = :id AND topics.subject_id = :subj_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $class, PDO::PARAM_INT);
        $stmt->bindParam(":subj_id", $subject, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $topics = [];
        foreach($rows as $row){
            $topics[] = new TopicEntity(
                (int)$row['topic_id'],
                $row['topic_title'],
                $row['subject_id']
            );
        }
        return $topics;
    }

    public function sort_detailed($class, int $subject){
        if($class > 11 || $class < 1){
            return [];
        }
        $sql = "SELECT DISTINCT
            topics.id AS topic_id, 
            topics.subject_id,
            topics.title AS topic_title, 
            `topic-class`.class_id, 
            more_classes.grouped_class_id, 
            more_classes.title AS class_title
        FROM topics
        JOIN `topic-class` ON topics.id = `topic-class`.topic_id
        JOIN more_classes ON `topic-class`.class_id = more_classes.id WHERE `topic-class`.class_id = :id AND topics.subject_id = :subj_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $class, PDO::PARAM_INT);
        $stmt->bindParam(":subj_id", $subject, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $topics = [];
        foreach($rows as $row){
            $topics[] = new TopicEntity(
                (int)$row['topic_id'],
                $row['topic_title'],
                $row['subject_id']
            );
        }
        return $topics;
    }
}