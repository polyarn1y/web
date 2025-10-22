<?php
session_start();


$img = @imagecreatefromjpeg('noise.jpg');

if (!$img) {
    die('Ошибка: не удалось загрузить noise.jpg. Проверьте путь к файлу.');
}

$width = imagesx($img);
$height = imagesy($img);

$textColor = imagecolorallocate($img, 0, 0, 0);

$fonts = [
    __DIR__ . '/fonts/bellb.ttf', 
    __DIR__ . '/fonts/georgia.ttf'
];

foreach ($fonts as $font) {
    if (!file_exists($font)) {
        die("Ошибка: шрифт не найден - $font");
    }
}

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captchaLength = rand(5, 6);
$captchaString = '';

for ($i = 0; $i < $captchaLength; $i++) {
    $captchaString .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha'] = $captchaString;

$x = 20;
$y = 35;

for ($i = 0; $i < strlen($captchaString); $i++) {
    $fontSize = rand(18, 30);
    
    $angle = rand(-15, 15);
    
    $font = $fonts[array_rand($fonts)];
    
    $result = imagettftext($img, $fontSize, $angle, $x, $y, $textColor, $font, $captchaString[$i]);
    
    if ($result === false) {
        imagedestroy($img);
        die("Ошибка imagettftext: проверьте поддержку FreeType");
    }
    
    $x += 40;
}

header('Content-Type: image/jpeg');
header('Cache-Control: no-cache, must-revalidate');
imagejpeg($img, null, 50);

imagedestroy($img);
?>
