<?php

class Todo
{
    public $id;
    public $title;
    public $completed;
    public $created_at;
    public $description;

    private $conn;
    private $table_name = "task";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create_todo()
    {
        $sql_query = "INSERT INTO " . $this->table_name . " (title, completed, description) VALUES (:title, :completed, :description)";

        $stmt = $this->conn->prepare($sql_query);

        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->completed = htmlspecialchars(strip_tags($this->completed));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind values
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':completed', $this->completed, PDO::PARAM_BOOL);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllTodo()
    {
        $sql_query = "SELECT * FROM " . $this->table_name . " ORDER  BY created_at DESC";

        $result = $this->conn->query($sql_query);

        return $result;
    }

    public function deleteTodo()
    {
        $sql_query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($sql_query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteCompletedTodo()
    {
        $sql_query = "DELETE FROM " . $this->table_name . " WHERE completed = 1";

        $stmt = $this->conn->prepare($sql_query);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function markCompleted()
    {
        $sql_query = "UPDATE " . $this->table_name . " SET completed  = :completed  WHERE id = :id";
        $stmt = $this->conn->prepare($sql_query);

        $this->title = htmlspecialchars(strip_tags($this->id));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam('completed', $this->completed, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllcompleted()
    {
        $sql_query = "SELECT * FROM " . $this->table_name . " WHERE completed = 1";

        $result = $this->conn->query($sql_query);

        return $result;
    }

    public function getAtive()
    {
        $sql_query = "SELECT * FROM " . $this->table_name . " WHERE completed = 0" . " ORDER  BY created_at DESC";

        $result = $this->conn->query($sql_query);

        return $result;
    }

    public function countAllActive()
    {
        $sql_query = "SELECT COUNT(id) as Active  FROM " . $this->table_name . " WHERE completed = 0";

        $result = $this->conn->query($sql_query);

        return $result;
    }
}
