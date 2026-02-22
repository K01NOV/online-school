<?php namespace App\Enum;

enum UserType: string {
    case Personal = 'Личный аккаунт';
    case Student = 'Ученик';
    case Teacher = 'Учитель';
    case Parent = 'Родитель';
    case Manager = 'Менеджер';
}
