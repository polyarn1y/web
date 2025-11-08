<h1>Все продукты</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Категория</th>
            <th>Стоимость</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $id => $product): ?>
            <?php $totalCost = $product['price'] * $product['quantity']; ?>
            <tr>
                <td><?= $id ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= $product['price'] ?>$</td>
                <td><?= $product['quantity'] ?></td>
                <td><?= htmlspecialchars($product['category']) ?></td>
                <td><?= $totalCost ?>$</td>
                <td><a href="/product/<?= $id ?>/">Подробнее</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>