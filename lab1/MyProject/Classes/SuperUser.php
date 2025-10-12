<?php
declare(strict_types=1);

namespace MyProject\Classes;

require_once __DIR__ . '/User.php';

use MyProject\Classes\User;
use MyProject\Classes\SuperUserInterface;

class SuperUser extends User implements SuperUserInterface
{
    /**
     * Роль супер-пользователя
     *
     * @var string
     */
    public string $role;

    /**
     * Статический счётчик созданных экземпляров SuperUser
     *
     * @var int
     */
    public static int $count = 0;

    public function __construct(string $name, string $login, string $password, string $role)
    {
        parent::__construct($name, $login, $password);
        $this->role = $role;
    }

    public function showInfo(): void
    {
        parent::showInfo();
        echo "Роль: " . $this->role . "<br>";
    }

    public function getInfo(): array
    {
        return [
            'name' => $this->name,
            'login' => $this->login,
            'role' => $this->role,
        ];
    }
}
