<?php namespace App\Control;

use App\Model\SearchModel;
use App\Control\SubjectController;
use App\Model\SubjectModel;
use App\Core\Security;
use PDO;

class SearchController{
    private $conn;
    private $searchModel;
    private $subjectController;
    private $subjectModel;

    public function __construct(PDO $db){
        $this->conn = $db;
        $this->searchModel = new SearchModel($this->conn);
        $this->subjectController = new SubjectController($this->conn);
        $this->subjectModel = new SubjectModel($this->conn);
    }

    public function prepare_searchResults(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
            if(!Security::check_token($_POST['token'])){
                header("Location: /registration");
                exit();
            }
            $_SESSION['last_query'] = $_POST['query'];
            
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $query = $_SESSION['last_query'] ?? '';

        if(empty($query)){
            $subjects = [];
            $topics = [];
            $lessons = [];
            $media = [];
        }
        else{
            $subjects = $this->searchModel->find_subjects($query);
            foreach($subjects as $subject){
                $subject->image = $this->subjectController->refresh_link($subject);
            }
            $topics = $this->searchModel->find_topics($query);
            $lessons = $this->searchModel->find_lessons($query);
            $media = $this->searchModel->find_media($query);
        }

        $type = $_GET['type'] ?? 'subject';
        switch($type){
            case 'subject':
                $result = $subjects;
                break;
            case 'topic':
                $result  = $topics;
                break;
            case 'lesson':
                $result = $lessons;
                break;
            case 'media':
                $result = $media;
                break;
            default:
                $result = $subjects;
                break;
        }
        require_once __DIR__ . "/../../View/head.php";
        require_once __DIR__ . "/../../View/search.php";
        require_once __DIR__ . "/../../View/footer.php";
        
    }


}