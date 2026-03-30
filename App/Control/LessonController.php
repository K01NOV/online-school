<?php namespace App\Control;

use App\Model\LessonModel;
use App\Model\SubjectModel;
use PDO;
class LessonController{
    private $conn;
    private $lessonModel;
    private $subjectModel;

    function __construct(PDO $db){
        $this->conn = $db;
        $this->lessonModel = new LessonModel($this->conn);
        $this->subjectModel = new SubjectModel($this->conn);
    }

    public function load_lesson(){
        require_once __DIR__ . "/../../View/head.php";
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $obj = $this->lessonModel->get_lesson_by_id((int)$_GET['id']);
            $subject_id = $obj['subject_id'];
            $lesson = $obj['lesson'];
            $contentStr = '';
            if($lesson){
                $contentStr = $lesson->content;
                $content = json_decode($contentStr, true);
                if (is_array($content)) {
                    foreach($content as &$piece) {
                        
                        if ($piece['type'] == 'image' && isset($piece['value'])) {
                            $piece['value'] = $this->subjectModel->getDirectLink($piece['value']);
                        }
                    }
                    unset($piece);
                }
                require_once __DIR__ . "/../../View/lessonSample.php";
            }
            
        }
        require_once __DIR__ . "/../../View/footer.php";
    }

}

