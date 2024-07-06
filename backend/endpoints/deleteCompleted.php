<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");

include_once("../config/database.php");
include_once("../Model/todo.php");

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $todoData = $todo->deleteCompletedTodo();

    if ($todoData) {
        http_response_code(200);
        echo json_encode(array(
            "status" => 1,
            "message" => "COMPLETED TODO SUCCESSFULLY DELETED"
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}
