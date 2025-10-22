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
        $dbExists = file_exists(self::DB_NAME) && filesize(self::DB_NAME) > 0;

        try {
            $this->_db = new PDO('sqlite:' . self::DB_NAME);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!$dbExists) {
                $this->createTables();
            }
        } catch (PDOException $e) {
            die('Невозможно создать базу данных: ' . $e->getMessage());
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
        
        try {
            $this->_db->beginTransaction();
            $this->_db->exec($sqlMsgs);
            $this->_db->exec($sqlCategory);
            $this->_db->exec($sqlInsertCategory);
            $this->_db->commit();
        } catch (PDOException $e) {
            $this->_db->rollBack();
            die('Невозможно создать базу данных: ' . $e->getMessage());
        }
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
                VALUES (" . $this->_db->quote($title) . ", " . 
                $this->_db->quote($category) . ", " . 
                $this->_db->quote($description) . ", " . 
                $this->_db->quote($source) . ", " . 
                time() . ")";
        
        try {
            $this->_db->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
            echo " (errorCode: " . $this->_db->errorCode() . ")";
            print_r($this->_db->errorInfo());
            return false;
        }
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
        
        try {
            $result = $this->_db->query($sql);
            
            $news = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $news[] = $row;
            }
            
            return $news;
        } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
            echo " (errorCode: " . $this->_db->errorCode() . ")";
            print_r($this->_db->errorInfo());
            return false;
        }
    }
    
    /**
     * Удаление записи из новостной ленты
     * 
     * @param integer $id - идентификатор удаляемой записи
     * 
     * @return boolean - результат успех/ошибка
     */
    public function deleteNews($id) {
        $sql = "DELETE FROM msgs WHERE id = " . $this->_db->quote($id);
        
        try {
            $this->_db->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
            echo " (errorCode: " . $this->_db->errorCode() . ")";
            print_r($this->_db->errorInfo());
            return false;
        }
    }
    
    public function __destruct() {
        $this->_db = null;
    }
}
?>
