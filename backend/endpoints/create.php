<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->title) && isset($data->completed) && isset($data->description)) {
        
        $todo->title = $data->title;
        $todo->completed = $data->completed;
        $todo->description = $data->description;

        if ($todo->create_todo()) {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Todo has been created"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to create todo"
            ));
        }

    } else {
        http_response_code(400);
        echo json_encode(array(
            "status" => 0,
            "message" => "Incomplete data provided"
        ));
    }

} else {
    http_response_code(405);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
?>
