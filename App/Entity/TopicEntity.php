<?php namespace App\Entity;

class TopicEntity{
    public $id;
    public $name;
    public $parent_id;
    public $order_num = 0;
    
    public function __construct(int $id, string $name, int $parent_id){
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
    }

}