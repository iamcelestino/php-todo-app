<?php

class Todo {

    public $text;
    public $completed;

    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "task";
    }

    public function create_todo()
    {
        $query = "INSERT INTO".$this->table_name."SET text=?, completed=?";
        $obj = $this->conn->prepare($query);

        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        $obj->bind_param('ss', $this->text, $this->completed);

        if($obj->execute()) {
            return true;
        }
        return false;
    }

    
}