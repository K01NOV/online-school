<?php namespace App\Entity;

class TopicEntity{
    public $id;
    public $name;
    public $parent_id;
    public $order_num = 0;
    public $lessons = [];
    public $subject_title;
    
    public function __construct(int $id, string $name, int $parent_id, ?string $subject_title = null){
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->subject_title = $subject_title;
    }

    public function write_lessons_amount(){
        $amount = count($this->lessons);
        $line = '';
        if($amount == 1 || ($amount % 100 > 20 && $amount % 10 == 1)){
            $line = $amount . ' урок';
        }
        else if($amount % 10 > 1 && $amount % 10 < 5 && ($amount < 10 || $amount % 100 > 20)){
            $line = $amount . ' урока';
        }
        else if($amount == 0){
            $line = 'нет уроков';
        }
        else{
            $line = $amount . ' уроков';
        }
        return $line;
    }

}