<?php namespace App\Entity;

use App\Enum\AgeRatings;
use App\Enum\MediaType;

class MediaEntity{
    public int $id;
    public string $name;
    public int $topic_id;
    public int $subject_id;
    public string $url;
    public string $image;
    public MediaType $type;
    public AgeRatings $age_rating;
    public string $description;
    public int $views;
    public int $likes;
    public int $dislikes;
    
    public function __construct(int $id, string $name, int $topic_id, int $subject_id, string $url, string $image, MediaType $type, AgeRatings $age, string $description, int $views, int $likes, int $dislikes){
        $this->id = $id;
        $this->name = $name;
        $this->topic_id = $topic_id;
        $this->subject_id = $subject_id;
        $this->url = $url;
        $this->image = $image;
        $this->type = $type;
        $this->age_rating = $age;
        $this->description = $description;
        $this->views = $views;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }

}