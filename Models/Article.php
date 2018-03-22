<?php

require_once("Database.php");

class Article {

    public $ID;
    public $UserName;
    public $CategoryName;
    public $Timestamp; 
    public $Title;
    public $Content;

    function __construct($id) {
        $this->ID = $id;
        $this->loadData($id);
    }

    private function loadData($id) {
        $myDB = new Database();

        $stmt = $myDB->mysqli->prepare('SELECT article.ID,
            user.name AS userName, 
            category.name AS categoryName, 
            article.timestamp, 
            article.title, 
            article.content  
        FROM article 
        JOIN user ON article.User_ID = user.id 
        JOIN category ON article.Category_ID = category.id
        WHERE article.ID = ?
        ORDER BY timestamp DESC');

        if (!$stmt->bind_param("i", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->bind_result($ID, $UserName, $CategoryName, $Timestamp, $Title, $Content);

        while ($stmt->fetch()) {
            $this->UserName = $UserName;
            $this->CategoryName = $CategoryName;
            $this->TimeStamp = $Timestamp;
            $this->Title = $Title;
            $this->Content = $Content;
        }
    }
}