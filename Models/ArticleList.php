<?php

require_once("Database.php");

class ArticleList {

    public $List = array();
    private $myDB;

    function __construct() {
        $this->myDB = new Database();
    }

    public function loadDataForAll() {
        $stmt = $this->myDB->mysqli->prepare('SELECT article.ID,
            user.name AS userName, 
            category.name AS categoryName, 
            article.timestamp, 
            article.title, 
            article.content  
        FROM article 
        JOIN user ON article.User_ID = user.id 
        JOIN category ON article.Category_ID = category.id
        ORDER BY timestamp DESC');

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->bind_result($ID, $UserName, $CategoryName, $Timestamp, $Title, $Content);

        while ($stmt->fetch()) {
            $this->List[$ID] = array($UserName, $CategoryName, $Timestamp, $Title, $Content);
        }
    }

    public function loadDataByDate($yearMonth) {
        $param = "%{$yearMonth}%";
        $stmt = $this->myDB->mysqli->prepare('SELECT article.ID,
            user.name AS userName, 
            category.name AS categoryName, 
            article.timestamp, 
            article.title, 
            article.content
        FROM article 
        JOIN user ON article.User_ID = user.id 
        JOIN category ON article.Category_ID = category.id
        WHERE article.timestamp LIKE ?
        ORDER BY timestamp DESC');

        if (!$stmt->bind_param("s", $param)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->bind_result($ID, $UserName, $CategoryName, $Timestamp, $Title, $Content);

        while ($stmt->fetch()) {
            $this->List[$ID] = array($UserName, $CategoryName, $Timestamp, $Title, $Content);
        }
    }
}