<?php
/**
 * Файл delete_news.inc.php
 * Обработка удаления новости
 */

$deleteId = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);

if ($deleteId === false || $deleteId === null) {
    header("Location: news.php");
    exit();
} else {
    $result = $news->deleteNews($deleteId);
    
    if ($result) {
        $_SESSION['success_message'] = "Новость успешно удалена!";
        header("Location: news.php");
        exit();
    } else {
        $errMsg = "Произошла ошибка при удалении новости";
    }
}
?>
