<?php namespace App\Entity;

class LessonEntity{
    public $id;
    public $name;
    public $parent_id;
    public $topic_title;
    public $subject_title;
    public $order_num = 0;
    
    public function __construct(int $id, string $name, int $parent_id, ?string $topic_title = null, ?string $subject_title = null){
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->topic_title = $topic_title;
        $this->subject_title = $subject_title;
    }

}