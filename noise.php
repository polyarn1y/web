<?php
session_start();

$backgroundPath = 'noise.jpg';
$fontsDir = 'fonts/';

$background = imagecreatefromjpeg($backgroundPath);
if (!$background) {
    die('Ошибка загрузки фонового изображения.');
}

$textColor = imagecolorallocate($background, 0, 0, 0);

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$captchaString = '';
$length = rand(5, 6);
for ($i = 0; $i < $length; $i++) {
    $captchaString .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha_string'] = $captchaString;

$fonts = [
    $fontsDir . 'bellb.ttf',
    $fontsDir . 'georgia.ttf'
];

$x = 20;
$y = 30;

for ($i = 0; $i < strlen($captchaString); $i++) {
    $char = $captchaString[$i];
    
    $font = $fonts[array_rand($fonts)];
    $fontSize = rand(18, 30);  
    $angle = rand(-30, 30);  
    
    imagettftext(
        $background,
        $fontSize,
        $angle,
        $x,
        $y,
        $textColor,
        $font,
        $char
    );
    
    $x += 40;
}

header('Content-Type: image/jpeg');
imagejpeg($background, null, 50);

imagedestroy($background);
?>