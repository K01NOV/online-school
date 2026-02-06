<?php namespace App\Enum;

enum AgeRatings: string{
    case General = '0+';
    case Children = '6+';
    case Teens = '12+';
    case YoungAdult = '16+';
    case Adult = '18+';
    case Not_Rated = '';
}