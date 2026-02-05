<?php namespace App\Control;

use App\Entity\SubjectEntity;
use Exception;
use PDO;
use App\Model\SubjectModel;
use App\Model\TopicModel;
use App\Model\LessonModel;

class SubjectController{
    private $conn;
    private $subjectModel;
    private $topicModel;
    private $lessonModel;

    function __construct(PDO $db){
        $this->conn = $db;
        $this->subjectModel = new SubjectModel($this->conn);
        $this->topicModel = new TopicModel($this->conn);
        $this->lessonModel = new LessonModel($this->conn);
    }

    public function display_subjects(){
        if(isset($_GET['grade'])){
            $subjects = $this->subjectModel->sort_detailed($_GET['grade']);
        }
        else if(isset($_GET['class'])){
            $subjects = $this->subjectModel->sort_wide($_GET['class']);
        }
        else{
            $subjects = $this->subjectModel->get_all();
        }

        $grades = $this->display_grades() ?? $_SESSION['grades'] ?? null;
        
        foreach ($subjects as $subject) {
            $subject->image = $this->refresh_link($subject);
        }

        $a = 'dashboard';
        
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . '/../../View/dashboard.php';
        require_once __DIR__ . "/../../View/footer.php";
    }

    public function display_grades(){
        $class = $_GET['class'] ?? null;
        $grade = $_GET['grade'] ?? null;
        if($class == null && $grade == null){
            unset($_SESSION['grades']);
            return null;
        }
        
        if($class != null){
            $grades = $this->subjectModel->get_grades($class);
            $_SESSION['grades'] = $grades;
            return $grades;
        }
        
        return $_SESSION['grades'] ?? null;
    }

    public function subject_info(){
        if(isset($_GET['id'])){
            $subject = $this->subjectModel->get_subject((int)$_GET['id']);
            $subject->image = $this->refresh_link($subject);
            if(isset($_GET['grade'])){
                $topics = $this->topicModel->sort_detailed((int)$_GET['grade'], $subject->id);
            }
            else if(isset($_GET['class'])){
                $topics = $this->topicModel->sort_wide($_GET['class'], $subject->id);
            }
            else{
                $topics = $this->topicModel->get_all($subject->id);
            }
            foreach($topics as $topic){
                $topic->lessons = $this->lessonModel->get_lessons($topic->id);
            }
            $grades = $this->display_grades() ?? $_SESSION['grades'] ?? null;
            $a = 'subject-info?id=' . urldecode($subject->id);
            
            require_once __DIR__ . "/../../View/head.php";
            require_once __DIR__ . "/../../View/subject_info.php";
            require_once __DIR__ . "/../../View/footer.php";
        }
        else{
            header("Location: /dashboard");
        }
    }

    public function refresh_link($subject){
        $now = time();
        $expire_time = 3600 * 4;

        if (!isset($_SESSION['image_url'][$subject->id]) || 
        !isset($_SESSION['image_time'][$subject->id]) || 
        ($now - $_SESSION['image_time'][$subject->id]) > $expire_time) {
            $_SESSION['image_url'][$subject->id] = $this->subjectModel->getDirectLink($subject->image);
            $_SESSION['image_time'][$subject->id] = $now;
        }

        return $_SESSION['image_url'][$subject->id];
    }
}