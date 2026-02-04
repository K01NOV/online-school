<?php namespace App\Control;

use App\Entity\SubjectEntity;
use Exception;
use PDO;
use App\Model\SubjectModel;

class SubjectController{
    private $conn;
    private $subjectModel;

    function __construct(PDO $db){
        $this->conn = $db;
        $this->subjectModel = new SubjectModel($this->conn);
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
            $subject = new SubjectEntity($subject['id'], $subject['title'], $subject['image_url']);
            $subject->image = $this->refresh_link($subject);
            
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
        $expire_time = 3600 * 10;

        if (!isset($_SESSION['image_url'][$subject->id]) || 
        !isset($_SESSION['image_time'][$subject->id]) || 
        ($now - $_SESSION['image_time'][$subject->id]) > $expire_time) {
            $_SESSION['image_url'][$subject->id] = $this->subjectModel->getDirectLink($subject->image);
            $_SESSION['image_time'][$subject->id] = $now;
        }

        return $_SESSION['image_url'][$subject->id];
    }
}