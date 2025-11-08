<ul>
<?php foreach ($users as $id => $u): ?>
  <li>id=<?= (int)$id ?> name=<?= htmlspecialchars($u['name']) ?> age=<?= htmlspecialchars($u['age']) ?> salary=<?= (int)$u['salary'] ?></li>
<?php endforeach; ?>
</ul>
