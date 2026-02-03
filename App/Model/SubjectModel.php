<?php namespace App\Model;

use Exception;
use PDO;
use App\Entity\SubjectEntity;

class SubjectModel{
    private $conn;
    private $yandexConfig;

    function __construct(PDO $db){
        $this->conn = $db;
        $this->yandexConfig = require __DIR__ . '/../Config/config.php';
    }

    function get_all(){
        $sql = "SELECT * FROM subjects";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $subjects = [];
        foreach($rows as $row){
            $subjects[] = new SubjectEntity(
                (int)$row['id'],
                $row['title'],
                $row['image_url']
            );
        }
        return $subjects;
    }

    public function sort_wide($class){
        $classes = [12, 13, 14];
        if(!in_array($class, $classes)){
            throw new Exception("Предметы для этого класса еще не были добавлены, мы над этим работаем и скоро добавим новые предметы");
        }
        $sql = "SELECT DISTINCT
            subjects.id, 
            subjects.title AS subject_title, 
            subjects.image_url, 
            classes.id AS class_id,
            classes.title AS class_title
        FROM subjects
        INNER JOIN `subject-class` ON subjects.id = `subject-class`.subject_id
        INNER JOIN classes ON `subject-class`.grouped_class_id = classes.id 
        WHERE classes.id = :class";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":class", $class, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $subjects = [];
        foreach($rows as $row){
            $subjects[] = new SubjectEntity(
                (int)$row['id'],
                $row['subject_title'],
                $row['image_url']
            );
        }
        return $subjects;
    }

    public function sort_detailed($class){
        if($class > 11 || $class < 1){
            throw new Exception("Предметы для этого класса еще не были добавлены, мы над этим работаем и скоро добавим новые предметы");
        }
        $sql = "SELECT DISTINCT 
            subjects.id, 
            subjects.title AS subject_title, 
            subjects.image_url 
        FROM subjects 
        INNER JOIN `subject-class` ON subjects.id = `subject-class`.subject_id 
        INNER JOIN more_classes ON `subject-class`.class_id = more_classes.id 
        WHERE more_classes.id = :class";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":class", $class, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $subjects = [];
        foreach($rows as $row){
            $subjects[] = new SubjectEntity(
                (int)$row['id'],
                $row['subject_title'],
                $row['image_url']
            );
        }
        return $subjects;
    }

    public function getDirectLink(string $publicUrl): string {
        $token = $this->yandexConfig['yandex']['token'];
        
        $apiUri = "https://cloud-api.yandex.net/v1/disk/public/resources?public_key=" . urlencode($publicUrl) . "&preview_size=L&preview_crop=true";

        $ch = curl_init($apiUri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $token]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // На локалке ок, на хостинге включим

        $response = curl_exec($ch);
        $data = json_decode($response, true);
        curl_close($ch);

        if (isset($data['preview'])) {
            return $data['preview'];
        }

        // Если превью нет, попробуем вернуть оригинальный href как запасной вариант
        return $data['file'] ?? $data['href'] ?? 'assets/img/no-image.png';
    }
}