<?php
/**
 * Файл get_news.inc.php
 * Вывод списка новостей из базы данных
 */
$allNews = $news->getNews();

if ($allNews === false) {
  $errMsg = "Произошла ошибка при выводе новостной ленты";
} else {
    $newsCount = count($allNews);
    
    echo "<h2>Список новостей</h2>";
    
    if ($newsCount > 0) {
        echo '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
        
        echo '<tr style="background-color: #f0f0f0;">';
        echo '<th>ID</th>';
        echo '<th>Заголовок</th>';
        echo '<th>Категория</th>';
        echo '<th>Описание</th>';
        echo '<th>Источник</th>';
        echo '<th>Дата</th>';
        echo '<th>Действие</th>';
        echo '</tr>';
        
        foreach ($allNews as $item) {
            echo '<tr>';
            echo '<td>' . $item['id'] . '</td>';
            echo '<td><strong>' . htmlspecialchars($item['title']) . '</strong></td>';
            echo '<td>' . htmlspecialchars($item['category']) . '</td>';
            echo '<td>' . htmlspecialchars($item['description']) . '</td>';
            echo '<td>' . htmlspecialchars($item['source']) . '</td>';
            echo '<td>' . date('d.m.Y H:i', $item['datetime']) . '</td>';
            
            echo '<td>';
            echo '<a href="news.php?delete_id=' . $item['id'] . '" ';
            echo 'onclick="return confirm(\'Вы уверены, что хотите удалить эту новость?\');" ';
            echo 'style="color: #dc3545; text-decoration: none;">Удалить</a>';
            echo '</td>';
            
            echo '</tr>';
        }
        
        echo '</table>';
        
        echo '<p>Всего новостей: ' . $newsCount . '</p>';
    } else {
        echo '<p>Новостей пока нет. Добавьте первую новость!</p>';
    }
}
?>
