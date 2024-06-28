<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../Model/todo.php";


$db = new Database();
$connection = $db->connect();


$todo = new Todo($connection);


if($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $todo->countAllActive();

    $active = $data->fetch(PDO::FETCH_DEFAULT);


    http_response_code(200);
    echo json_encode(array(
        "status" => 1,
        "data" => $active
    ));

}else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "ACCESS DENIED"
    ));
}



?>