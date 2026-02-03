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
        
        foreach ($subjects as $subject) {
            if(!isset($_SESSION['image_url'][$subject->id])){
                $_SESSION['image_url'][$subject->id] = $this->subjectModel->getDirectLink($subject->image);
            }
            $subject->image = $_SESSION['image_url'][$subject->id];
        }
        
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . '/../../View/dashboard.php';
        require_once __DIR__ . "/../../View/footer.php";
    }
}