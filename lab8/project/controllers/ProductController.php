<?php
namespace Project\Controllers;

use Core\Controller;

class ProductController extends Controller
{
    private array $products = [
        1 => [
            'name'     => 'product1',
            'price'    => 100,
            'quantity' => 5,
            'category' => 'category1',
        ],
        2 => [
            'name'     => 'product2',
            'price'    => 200,
            'quantity' => 6,
            'category' => 'category2',
        ],
        3 => [
            'name'     => 'product3',
            'price'    => 300,
            'quantity' => 7,
            'category' => 'category2',
        ],
        4 => [
            'name'     => 'product4',
            'price'    => 400,
            'quantity' => 8,
            'category' => 'category3',
        ],
        5 => [
            'name'     => 'product5',
            'price'    => 500,
            'quantity' => 9,
            'category' => 'category3',
        ],
    ];

    public function show($params = [])
    {
        $id = (int)($params['n'] ?? 0);

        if (!isset($this->products[$id])) {
            $this->title = "Продукт не найден";
            return $this->render('product/not-found', ['id' => $id]);
        }

        $product = $this->products[$id];
        $totalCost = $product['price'] * $product['quantity'];
        $this->title = "Продукт {$product['name']}";
        return $this->render('product/show', [
            'product' => $product,
            'totalCost' => $totalCost
        ]);
    }

    public function all($params = [])
    {
        $this->title = "Все продукты";
        return $this->render('product/all', [
            'products' => $this->products
        ]);
    }

       public function one($params)
    {
        $id = $params['id'] ?? 0;
        
        $product = (new Product)->getById($id);
        
        if (!$product) {
            $this->title = "Продукт не найден";
            return $this->render('product/not-found', [
                'h1' => $this->title
            ]);
        }
        
        $this->title = $product['name'];
        return $this->render('product/one', [
            'product' => $product,
            'h1' => $this->title
        ]);
    }
}