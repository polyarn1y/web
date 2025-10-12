<?php
session_start();
require_once 'NewsDB.class.php';
$news = new NewsDB();
$errMsg = "";
$successMsg = "";
if (isset($_SESSION['success_message'])) {
    $successMsg = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_GET['delete_id'])) {
    include 'delete_news.inc.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'save_news.inc.php';
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Новостная лента</title>
  <meta charset="utf-8">
  <style>
   .error { color: red; background: #ffe6e6; padding: 10px; margin: 10px 0; border: 1px solid red; border-radius: 5px; }
   .success { color: green; background: #e6ffe6; padding: 10px; margin: 10px 0; border: 1px solid green; border-radius: 5px; }
   </style>
</head>
<body>
  <h1>Последние новости</h1>
  
  <?php
  if ($successMsg !== "") {
      echo '<div class="success">' . htmlspecialchars($successMsg) . '</div>';
  }
  
  if ($errMsg !== "") {
      echo '<div class="error">' . htmlspecialchars($errMsg) . '</div>';
  }
  ?>
  
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    Заголовок новости:<br>
    <input type="text" name="title"><br>
    Выберите категорию:<br>
    <select name="category">
      <option value="1">Политика</option>
      <option value="2">Культура</option>
      <option value="3">Спорт</option>
    </select>
    <br />
    Текст новости:<br>
    <textarea name="description" cols="50" rows="5"></textarea><br>
    Источник:<br>
    <input type="text" name="source"><br>
    <br>
    <input type="submit" value="Добавить!">
  </form>
  
  <?php
  include 'get_news.inc.php';
  ?>
</body>
</html>
