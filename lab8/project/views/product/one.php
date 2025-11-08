<h1><?= htmlspecialchars($h1); ?></h1>
<div id="content">
    <p><strong>Название:</strong> <?= htmlspecialchars($product['name']); ?></p>
    <p><strong>Цена:</strong> <?= number_format($product['price'], 2, ',', ' '); ?> руб.</p>
    <p><strong>Количество:</strong> <?= $product['quantity']; ?></p>
    <p><strong>Описание:</strong> <?= htmlspecialchars($product['description']); ?></p>
</div>
<a href="/products/">Вернуться к списку продуктов</a>