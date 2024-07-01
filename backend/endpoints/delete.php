<?php
header("Access-Control-Allow-origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    if (isset($_GET['id'])) {
        $todo->id = $_GET['id'];
        $todoData = $todo->deleteTodo();

        if ($todoData) {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Todo deleted successfully."
            ));
        } 
    } else {
        http_response_code(400);
        echo json_encode(array(
            "status" => 0,
            "message" => "ID is missing."
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
