<?php
namespace Project\Controllers;
use Core\Controller;

class UserController extends Controller
{
    private array $users = [
        1 => ['name'=>'user1', 'age'=>'23', 'salary' => 1000],
        2 => ['name'=>'user2', 'age'=>'24', 'salary' => 2000],
        3 => ['name'=>'user3', 'age'=>'25', 'salary' => 3000],
        4 => ['name'=>'user4', 'age'=>'26', 'salary' => 4000],
        5 => ['name'=>'user5', 'age'=>'27', 'salary' => 5000],
    ];

    public function show($params = [])
    {
        $id = (int)($params['id'] ?? 0);
        if (!isset($this->users[$id])) {
            $this->title = "Пользователь не найден";
            return $this->render('user/not-found', ['id' => $id]);
        }
        $user = $this->users[$id];
        $this->title = "Пользователь {$user['name']}";
        return $this->render('user/show', ['id' => $id, 'user' => $user]);
    }

    public function info($params = [])
    {
        $id  = (int)($params['id'] ?? 0);
        $key = $params['key'] ?? '';
        if (!isset($this->users[$id])) {
            $this->title = "Пользователь не найден";
            return $this->render('user/not-found', ['id' => $id]);
        }
        if (!in_array($key, ['name','age','salary'], true)) {
            $this->title = "Неверный ключ";
            return $this->render('user/bad-key', ['key' => $key]);
        }
        $this->title = "Информация о пользователе {$this->users[$id]['name']}";
        return $this->render('user/info', [
            'id'   => $id,
            'key'  => $key,
            'value'=> $this->users[$id][$key],
        ]);
    }

    public function all($params = [])
    {
        $this->title = "Все пользователи";
        return $this->render('user/all', ['users' => $this->users]);
    }

    public function first($params = [])
    {
        $n = max(0, (int)($params['n'] ?? 0));
        $slice = array_slice($this->users, 0, $n, true);
        $this->title = "Первые {$n} пользователей";
        return $this->render('user/first', ['users' => $slice, 'n' => $n]);
    }
}