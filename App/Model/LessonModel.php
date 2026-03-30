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
                $row['topic_id'],
                '',
                $row['content']
            );
        }

        return $lessons;
    }

    public function get_lesson_by_id(int $id){
        $sql = "SELECT 
        lessons.*, 
        topics.title AS topic_title, 
        subjects.title AS subject_title,
        subjects.id AS subj_id
        FROM lessons 
        JOIN topics ON lessons.topic_id = topics.id 
        JOIN subjects ON topics.subject_id = subjects.id 
        WHERE lessons.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $lesson = null;

        $lesson = new LessonEntity(
            $row['id'],
            $row['title'],
            $row['topic_id'],
            $row['topic_title'],
            $row['subject_title'],
            $row['content']
        );

        return ['lesson' => $lesson, 'subject_id' => $row['subj_id']];
    }

}