<?php
spl_autoload_register();

use MVC\Views\ViewFactory;
use MVC\Decorators\UsersMarkdownDecorator;
use MVC\Models\Users;

$users = new Users();

$decorator = new UsersMarkdownDecorator($users);

$view = ViewFactory::create('markdown', 'users', $decorator);

echo "<pre>";  
echo $view->render();
echo "</pre>";