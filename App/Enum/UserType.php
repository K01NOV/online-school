<?php namespace App\Enum;

enum UserType: string {
    case Personal = 'Personal';
    case Student = 'Student';
    case Teacher = 'Teacher';
    case Parent = 'Parent';
    case Manager = 'Manager';

    public function label(): string {
        return match($this) {
            self::Personal => 'Личный аккаунт',
            self::Student  => 'Ученик',
            self::Teacher  => 'Учитель',
            self::Parent   => 'Родитель',
            self::Manager  => 'Менеджер',
        };
    }

    public static function from_ru(string $ru){
        foreach(self::cases() as $type){
            if($type->label() === $ru){
                if(!in_array($type, self::publicRoles())){
                    throw new \InvalidArgumentException("Недопустимая роль: " . $ru);
                }
                return $type;
            }
        }
        throw new \InvalidArgumentException("Недопустимая роль: " . $ru);
    }

    public static function publicRoles(): array {
        return [self::Personal, self::Student, self::Teacher, self::Parent];
    }
}
