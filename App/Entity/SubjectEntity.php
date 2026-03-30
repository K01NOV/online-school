<?php namespace App\Entity;

class SubjectEntity{
    public $id;
    public $name;
    public $image;
    public $description;
    
    public function __construct(int $id, string $name, string $image, ?string $description = ''){
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->description = $description;
    }

}