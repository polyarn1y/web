<?php
/**
 * Файл save_news.inc.php
 * Обработка HTML-формы для добавления новости
 */

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$source = filter_input(INPUT_POST, 'source', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (empty($title) || empty($category) || empty($description) || empty($source)) {
    $errMsg = "Заполните все поля формы!";
} else {
    $result = $news->saveNews($title, $category, $description, $source);    
    if ($result) {
        $_SESSION['success_message'] = "Новость успешно добавлена!";
        header("Location: news.php");
        exit();
    } else {
        $errMsg = "Произошла ошибка при добавлении новости";
    }
}
?>
