<?php

class Todo {

    public $id;
    public $title;
    public $completed;
    public $created_at;
    public $description;

    private $conn;
    private $table_name = "task";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create_todo() {
        $sql_query = "INSERT INTO " . $this->table_name . " (title, completed, description) VALUES (:title, :completed, :description)";
        
        $stmt = $this->conn->prepare($sql_query);

        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->completed = htmlspecialchars(strip_tags($this->completed));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind values
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':completed', $this->completed);
        $stmt->bindParam(':description', $this->description);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllTodo() {

       $sql_query = "SELECT * FROM " . $this->table_name;

       $result = $this->conn->query($sql_query);

       return $result;
    }

    public function getSingleTodo()
    {
        $sql_query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($sql_query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $todo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $todo;

    }
}
?>
