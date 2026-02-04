<?php namespace App\Entity;

class SubjectEntity{
    public $id;
    public $name;
    public $image;
    
    public function __construct(int $id, string $name, string $image){
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }

}