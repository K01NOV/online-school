<?php namespace App\Control;

      use App\Model\LessonModel;
      use App\Model\SubjectModel;
      use App\Model\TopicModel;

class SubjectEditController{
    private $conn;
    private $subjectModel;
    private $topicModel;
    private $lessonModel;
    private $subjectController;

    public function __construct($db){
        $this->conn = $db;
        $this->subjectModel = new SubjectModel($this->conn);
        $this->subjectController = new SubjectController($this->conn);
        $this->topicModel = new TopicModel($this->conn);
        $this->lessonModel = new LessonModel($this->conn);
    }

    public function show_editor(){
        $subjects = $this->subjectModel->get_all();
        foreach ($subjects as $subject) {
            $subject->image = $this->subjectController->refresh_link($subject);
        }
        if(isset($_GET['id'])){
            $current = $this->subjectModel->get_subject((int)$_GET['id']);
            $current->image = $this->subjectController->refresh_link($current);
            $topics = $this->topicModel->get_all($current->id);
            foreach($topics as $topic){
                $topic->lessons = $this->lessonModel->get_lessons($topic->id);
            }
        }
        require_once __DIR__ . '/../../View/admin_head.php';
        require_once __DIR__ . '/../../View/admin_subjects.php';
        require_once __DIR__ . "/../../View/footer.php";
        //require_once __DIR__ . '/../../View/subject_list.php';
    }
}