<?php namespace App\Control;

use App\Model\SubjectModel;
use App\Control\SubjectController;
use App\Model\TopicModel;

class PagesController{
    private $subjectModel;
    private $conn;
    private $subjectController;
    private $topicModel;
    function __construct($db){
        $this->conn = $db;
        $this->subjectModel = new SubjectModel($this->conn);
        $this->subjectController = new SubjectController($this->conn);
        $this->topicModel = new TopicModel($this->conn);
    }
    function showHome(){
        $subjects = $this->subjectModel->get_all();
        $realSubjects = [];
        foreach ($subjects as $subject) {
            $topics = $this->topicModel->get_all($subject->id);
            if(count($topics) > 0){
                $subject->image = $this->subjectController->refresh_link($subject);
                $realSubjects[] = $subject;
            }
        }
        $subjects = $realSubjects;
        
        require_once __DIR__ . "/../../View/head_home.php";
        require_once __DIR__ . "/../../View/home.php";
        require_once __DIR__ . "/../../View/footer.php";
    }

    function showRegistration(){
        require_once __DIR__ . "/../../View/head_home.php";
        require_once __DIR__ . "/../../View/register.php";
        require_once __DIR__ . "/../../View/footer.php";
    }

    function showAdmin(){
        require_once __DIR__ . "/../../View/admin_head.php";
        require_once __DIR__ . "/../../View/admin_crud.php";
        require_once __DIR__ . "/../../View/footer.php";
    }
    function showLesson(){
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . '/../../View/lessonSample.php';
        require_once __DIR__ . "/../../View/footer.php";
    }
}