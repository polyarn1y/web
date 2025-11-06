<?php
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['captcha_string'])) {
        $message = "<p style='color:red'>Изображения отключены в браузере. Пожалуйста, включите показ изображений для продолжения.</p>";
    } else {
        $userAnswer = $_POST['answer'] ?? '';
        $captchaString = $_SESSION['captcha_string'];
        
        if ($userAnswer === $captchaString) {
            $message = "<p style='color:green'>Верно! Регистрация успешна.</p>";
        } else {
            $message = "<p style='color:red'>Неверно! Попробуйте еще раз.</p>";
        }
        
        unset($_SESSION['captcha_string']);
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
      <img src="noise.php" alt="Капча">
      <noscript>
        <p style="color:red">Для работы капчи необходим JavaScript или включенные изображения.</p>
      </noscript>
    </div>
    <div>
      <label>Введите строку</label>
      <input type="text" name="answer" size="6" required>
    </div>
    <input type="submit" value="Подтвердить">
  </form>
  <?= $message ?>
</body>
</html>