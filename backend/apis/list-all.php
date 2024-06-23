<?php
header('Access-Control-Allow-origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);

if ($_SERVER['REQUEST_METHOD'] ===  'GET') {

    $data = $todo->getAllTodo();

    if ($data) {

        $ass['record'] = array();

        while (($row = $data->fetch(PDO::FETCH_ASSOC)) != false) {
            array_push($ass['record'], array(
                "id" => $row['id'],
                "title" => $row['title'],
                "completed" => $row['completed'],
                "created_at" => date("y-m-d", strtotime($row['created_at'])),
                "description" => $row['description']
            ));
        }
        htmlspecialchars(200);
        echo json_encode(array(
            "status" => 1,
            "data" => $ass['record']
        ));
    }
} else {
    htmlspecialchars(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}


?>