<?php
$prod = $product;
?>
<h1>Продукт "<?= htmlspecialchars($prod['name']) ?>" из категории "<?= htmlspecialchars($prod['category']) ?>"</h1>
<p> 
    Цена: <?= $prod['price'] ?>$, количество: <?= $prod['quantity'] ?>
</p>
<p>
    Стоимость (цена * количество): <?= $totalCost ?>$
</p>
<a href="/products/all/">Вернуться к списку всех продуктов</a>