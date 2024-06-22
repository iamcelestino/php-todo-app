<?php

header("Access-Control-Allow-Origin: *");
header("Contet-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id) && !empty($data->completed)) {

        $todo->id = $data->id;
        $todo->completed = $data->completed;

        if ($todo->markCompleted()) {

            http_response_code(200); //OK
            echo json_encode(array(
                "status" => 1,
                "message" => "TODO DATA UPDATED SUCCESSFULLY"
            ));

        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to update data"
            ));
        }
    } else {
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => "data need"
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 1,
        "message" => "Access Denied"
    ));
}
