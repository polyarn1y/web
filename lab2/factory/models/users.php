<?php
namespace Factory\Models;

class Users extends Collection
{
    public function __construct(public ?array $users = null)
    {
        $users ??= [
            new User('dmitry.koterov@gmail.com', 'password', 'Дмитрий', 'Котеров'),
            new User('igorsimdyanov@gmail.com', 'password', 'Игорь', 'Симдянов'),
            new User('anna.ivanova@gmail.com', 'password', 'Анна', 'Иванова'),
            new User('sergey.petrov@gmail.com', 'password', 'Сергей', 'Петров'),
            new User('elena.smirnova@gmail.com', 'password', 'Елена', 'Смирнова'),
        ];
        parent::__construct($users);
    }
}
