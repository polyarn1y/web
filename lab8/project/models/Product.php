<?php
namespace Project\Models;
use \Core\Model;

class Product extends Model
{
    public function getById($id)
    {
        $id = (int)$id;
        return $this->findOne("SELECT * FROM products WHERE id=$id");
    }
    
    public function getAll()
    {
        return $this->findMany("SELECT id, name, price, quantity FROM products");
    }
}