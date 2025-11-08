<?php
namespace Project\Controllers;

use Core\Controller;
use \Project\Models\Page;
class PageController extends Controller
{
    private array $pages = [
        1 => ['title'=>'страница 1', 'text'=>'текст страницы 1'],
        2 => ['title'=>'страница 2', 'text'=>'текст страницы 2'],
        3 => ['title'=>'страница 3', 'text'=>'текст страницы 3'],
    ];

    public function test() {
        $page = new Page; 
    
        $dataById3 = $page->getById(3);
        $dataById5 = $page->getById(5);
        $dataByRange = $page->getByRange(2, 5);

        $this->title = "Тест модели Page";

        return $this->render('page/test', [
            'recordById3' => $dataById3,
            'recordById5' => $dataById5,
            'recordsByRange' => $dataByRange
        ]);
    }

    public function show($params = [])
    {
        $id = (int)($params['id'] ?? 0);

        if (!isset($this->pages[$id])) {
            $this->title = "Страница не найдена";
            return $this->render('page/not-found', ['id' => $id]);
        }

        $pageData = $this->pages[$id];
        $this->title = $pageData['title'];
        return $this->render('page/show', [
            'page' => $pageData
        ]);
    }
}