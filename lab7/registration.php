<?php 
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['captcha'])) {
        $message = '<p style="color: red;">Ошибка: изображение не было загружено. Возможно, в вашем браузере отключен показ картинок.</p>';
    } else {
        $userAnswer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
        
        if (strtoupper($userAnswer) === $_SESSION['captcha']) {
            $message = '<p style="color: green;">Правильно! Вы ввели корректную строку.</p>';
        } else {
            $message = '<p style="color: red;">Неправильно! Попробуйте еще раз.</p>';
        }
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <title>Регистрация</title>
</head>

<body>
  <h1>Регистрация</h1>
  <form action="" method="post">
    <div>
      <img src="noise.php?<?php echo time(); ?>" alt="CAPTCHA">
    </div>
    <div>
      <label>Введите строку</label>
      <input type="text" name="answer" size="6" required>
    </div>
    <input type="submit" value="Подтвердить">
  </form>
  <?php 
    echo $message;
  ?>
</body>

</html>
