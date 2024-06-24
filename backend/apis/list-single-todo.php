<?php
header("Access-Control-Allow-Origin: *");
header("Contet-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");


include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $param = json_decode(file_get_contents("php://input"));

    if (isset($param->id)) {
        $todo->id = $param->id;
        $todoData = $todo->getSingleTodo();
    }
    http_response_code(200);
    echo json_encode(array(
        "status" => 1,
        "data" => $todoData
    ));
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "ACCESS DENIED"
    ));
}
