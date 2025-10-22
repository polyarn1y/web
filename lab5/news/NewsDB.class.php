<?php
require_once 'INewsDB.class.php';

class NewsDB implements INewsDB {
    const DB_NAME = 'news.db';
    const RSS_NAME = 'rss.xml';
    const RSS_TITLE = 'Последние новости';
    const RSS_LINK = 'https://polyarn1y.ru/news/news.php';

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

        $this->createRss();

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
     * Формирование RSS-документа
     */
    public function createRss() {
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        $rss = $dom->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $dom->appendChild($rss);

        $channel = $dom->createElement('channel');
        $rss->appendChild($channel);

        $title = $dom->createElement('title', self::RSS_TITLE);
        $channel->appendChild($title);

        $link = $dom->createElement('link', self::RSS_LINK);
        $channel->appendChild($link);

        $news = $this->getNews();
        if ($news) {
            foreach ($news as $row) {
                $item = $dom->createElement('item');

                $itemTitle = $dom->createElement('title', $row['title']);
                $item->appendChild($itemTitle);

                $itemLink = $dom->createElement('link', $row['source']);
                $item->appendChild($itemLink);

                $desc = $dom->createElement('description');
                $cdata = $dom->createCDATASection($row['description']);
                $desc->appendChild($cdata);
                $item->appendChild($desc);

                $pubDate = $dom->createElement('pubDate', date(DATE_RSS, $row['datetime']));
                $item->appendChild($pubDate);

                $category = $dom->createElement('category', $row['category']);
                $item->appendChild($category);

                $channel->appendChild($item);
            }
        }

        $dom->save(self::RSS_NAME);
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
