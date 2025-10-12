<?php
declare(strict_types=1);

use MyProject\Classes\User;
use MyProject\Classes\SuperUser;

function my_autoloader($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($path)) {
        include $path;
    }
}

spl_autoload_register('my_autoloader');

$user1 = new User("Vladimir", "KalinichevVladimir", "password1");
$user2 = new User("Dmitriy", "dmitriy", "password2");
$user3 = new User("Ivan", "ivan_user", "password3");
echo "<br>";

$user1->showInfo();
$user2->showInfo();
$user3->showInfo();
echo "<br>";

$user = new SuperUser("Root", "root", "password1", "admin");
$user->showInfo();
echo "<br>";

echo "<strong>Информация о суперпользователе (через getInfo()):</strong><br>";
echo "<pre>";
print_r($user->getInfo());
echo "</pre>";

echo "<br>Всего обычных пользователей: " . User::$count . "<br>";
echo "Всего супер-пользователей: " . SuperUser::$count . "<br>";
?>
