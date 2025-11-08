<?php
	namespace Project\Controllers;
	use \Core\Controller;
	
	class NumController extends Controller
	{
    public function sum($params = [])
    {
        $n1 = (int)($params['n1'] ?? 0);
        $n2 = (int)($params['n2'] ?? 0);
        $n3 = (int)($params['n3'] ?? 0);
        return $this->render('num/index', ['msg' => 'Сумма чисел: ' . $n1+$n2+$n3]);
    }
	}
