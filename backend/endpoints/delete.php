<?php
header("Access-Control-Allow-origin: *");
header("Access-Control-Allow-Methods: DELETE");

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);


if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $param = json_decode(file_get_contents("php://input"));

    if (isset($param->id)) {
        $todo->id = $param->id;
        $todoData = $todo->deleteTodo();
    }
    http_response_code(200);
    echo json_encode(array(
        "status" => 1,
        "message" => $todoData . "Deleted successfull"
    ));
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
