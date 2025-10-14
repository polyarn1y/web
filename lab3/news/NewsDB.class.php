<?php
require_once 'INewsDB.class.php';

class NewsDB implements INewsDB {
    const DB_NAME = 'news.db';
    private $_db;
    
    protected function getDb() {
        return $this->_db;
    }
    
    public function __construct() {
        date_default_timezone_set('Europe/Moscow');
        $dbExists = file_exists(self::DB_NAME);
        $this->_db = new SQLite3(self::DB_NAME);

        if (!$dbExists) {
            $this->createTables();
        }
    }
    
    private function createTables() {
        $sqlMsgs = "CREATE TABLE msgs(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            category INTEGER,
            description TEXT,
            source TEXT,
            datetime INTEGER
        )";
        
        $sqlCategory = "CREATE TABLE category(
            id INTEGER,
            name TEXT
        )";
        
        $sqlInsertCategory = "INSERT INTO category(id, name)
            SELECT 1 as id, 'Политика' as name
            UNION SELECT 2 as id, 'Культура' as name
            UNION SELECT 3 as id, 'Спорт' as name";
        
        $this->_db->exec($sqlMsgs);
        $this->_db->exec($sqlCategory);
        $this->_db->exec($sqlInsertCategory);
    }
    
    /**
     * Добавление новой записи в новостную ленту
     * 
     * @param string $title - заголовок новости
     * @param string $category - категория новости
     * @param string $description - текст новости
     * @param string $source - источник новости
     * 
     * @return boolean - результат успех/ошибка
     */
    public function saveNews($title, $category, $description, $source) {
        $sql = "INSERT INTO msgs (title, category, description, source, datetime) 
                VALUES (:title, :category, :description, :source, :datetime)";
        
        $stmt = $this->_db->prepare($sql);
        
        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':category', $category, SQLITE3_INTEGER);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':source', $source, SQLITE3_TEXT);
        $stmt->bindValue(':datetime', time(), SQLITE3_INTEGER);
        
        $result = $stmt->execute();
        
        return $result !== false;
    }
    
    /**
     * Выборка всех записей из новостной ленты
     * 
     * @return array|false - результат выборки в виде массива или false при ошибке
     */
    public function getNews() {
        $sql = "SELECT msgs.id as id, title, category.name as category, 
                      description, source, datetime
                FROM msgs, category
                WHERE category.id = msgs.category
                ORDER BY msgs.id DESC";
        
        $result = $this->_db->query($sql);
        
        if (!$result) {
            return false; 
        }
        
        $news = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $news[] = $row;
        }
        
        return $news;
    }

    
    /**
     * Удаление записи из новостной ленты
     * 
     * @param integer $id - идентификатор удаляемой записи
     * 
     * @return boolean - результат успех/ошибка
     */
    public function deleteNews($id) {
        $sql = "DELETE FROM msgs WHERE id = :id";
        
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
        $result = $stmt->execute();
        
        return $result !== false;
    }
    
    public function __destruct() {
        if ($this->_db) {
            $this->_db->close();
        }
    }
}
?>
