<?php foreach ($users as $id => $user): ?>
<div>
    <h3>Пользователь #<?= $id ?></h3>
    <p>Имя: <?= $user['name'] ?></p>
    <p>Возраст: <?= $user['age'] ?></p>
    <p>Зарплата: <?= $user['salary'] ?></p>
</div>
<?php endforeach; ?>