<?php
header('Access-Control-Allow-origin: *');
header('Access-Control-Allow-Methods: GET');

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if($_SERVER['REQUEST_METHOD'] ===  'GET') {
    
    $data = $todo->getAllTodo();
}
else {
    htmlspecialchars(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}















?>