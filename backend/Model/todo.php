<?php

declare(strict_types=1);

namespace App\Model;

class Todo {
    private $conn;
    private $table_name = "task";
    
    public $id;
    public $title;
    public $completed;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO".$this->table_name."SET title=:title, completed=:title";
       $statement = $this->conn->prepare($query);

       $this->title = htmlspecialchars(strip_tags($this->title));
       $this->completed = htmlspecialchars(strip_tags($this->completed));

       $statement->bindParam(":title", $this->title);
       $statement->bindParam(":completed", $this->completed);

       if ($statement->execute()) {
            return true;
       }
       else {
            return false;
       }
        
    }

    public function read()
    {
        $query = "SELECT * FROM ".$this->table_name;
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }
}


