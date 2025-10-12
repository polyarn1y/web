<?php
declare(strict_types=1);

namespace MyProject\Classes;

use MyProject\Classes\AbstractUser;

class User extends AbstractUser
{
    /**
     * Имя пользователя
     *
     * @var string
     */
    public string $name;

    /**
     * Логин пользователя
     *
     * @var string
     */
    public string $login;

    /**
     * Пароль пользователя (приватное свойство)
     *
     * @var string
     */
    private string $password;

    /**
     * Статический счётчик созданных экземпляров User
     *
     * @var int
     */
    public static int $count = 0;

    public function __construct(string $name, string $login, string $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        static::$count++;
        echo "Пользователь {$this->login} создан<br>";
      }

    public function __destruct()
    {
        echo "Пользователь {$this->login} удален<br>";
    }

    public function showInfo(): void
    {
        echo "Имя: {$this->name}, " . "логин: {$this->login}<br>";
    }
}
