<?php
	namespace Project\Controllers;
	use \Core\Controller;
	
	class TestController extends Controller
	{
    public function act1() { 
      $this->title = 'Действие act1 контроллера test';
      return $this->render('test/act1', ['msg' => 'act1 OK']); 
    }

    public function act2() { 
      $this->title = 'Действие act2 контроллера test';
      return $this->render('test/act2', ['msg' => 'act2 OK']); 
    }  
    public function act3() {
      $this->title = 'Действие act3 контроллера test';
      return $this->render('test/act3', ['msg' => 'act3 OK']); 
    }
	}
