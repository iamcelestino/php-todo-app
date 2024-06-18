<?php

header("Access-Control-Allow-origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Controll-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();

$todo = new Todo($connection);
