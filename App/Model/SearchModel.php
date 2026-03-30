<?php namespace App\Model;

use App\Entity\LessonEntity;
use App\Entity\MediaEntity;
use App\Entity\SubjectEntity;
use App\Entity\TopicEntity;
use App\Enum\AgeRatings;
use App\Enum\MediaType;
use PDO;

class SearchModel{
    private $conn;

    function __construct(PDO $db){
        $this->conn = $db;
    }

    public function find_subjects($query){
        $sql = "SELECT * FROM subjects WHERE title LIKE :query";
        $stmt = $this->conn->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam(":query", $query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subjects = [];
        
        foreach($rows as $row){
            $subjects[] = new SubjectEntity(
                $row['id'],
                $row['title'],
                $row['image_url'],
                $row['description']
            );
        }
        return $subjects;
    }

    public function find_topics($query){
        $sql = "SELECT topics.*, subjects.title AS subject_title FROM topics JOIN subjects ON topics.subject_id = subjects.id WHERE topics.title LIKE :query";
        $stmt = $this->conn->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam(":query", $query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $topics = [];

        foreach($rows as $row){
            $topics[] = new TopicEntity(
                $row['id'],
                $row['title'],
                $row['subject_id'],
                $row['subject_title']
            );
        }

        return $topics;
    }

    public function find_lessons($query){
        $sql = "SELECT 
        lessons.*, 
        topics.title AS topic_title, 
        subjects.title AS subject_title 
        FROM lessons 
        JOIN topics ON lessons.topic_id = topics.id 
        JOIN subjects ON topics.subject_id = subjects.id 
        WHERE lessons.title LIKE :query";
        $stmt = $this->conn->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam(":query", $query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lessons = [];

        foreach($rows as $row){
            $lessons[] = new LessonEntity(
                $row['id'],
                $row['title'],
                $row['topic_id'],
                $row['topic_title'],
                $row['subject_title'],
                null
            );
        }
        return $lessons;
    }

    public function find_media($query){
        $sql = "SELECT 
            media.*, 
            topics.title AS topic_title, 
            subjects.title AS subject_title
        FROM media
        JOIN topics ON media.topic_id = topics.id
        JOIN subjects ON topics.subject_id = subjects.id
        WHERE media.title LIKE :query";

        $stmt = $this->conn->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam(":query", $query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $media = [];

        foreach($rows as $row){
            $media[] = new MediaEntity(
                $row['id'],
                $row['name'],
                $row['topic_id'],
                $row['subject_id'],
                $row['url'],
                $row['image'],
                MediaType::from($row['type']),
                AgeRatings::from($row['age_rating']),
                $row['description'],
                $row['views'],
                $row['likes'],
                $row['dislikes']
            );
        }
        return $media;
    }
}