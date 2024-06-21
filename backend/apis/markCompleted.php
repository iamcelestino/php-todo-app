<?php

include_once "../config/database.php";
include_once "../Model/todo.php";

$db = new Database();
$connection = $db->connect();


$todo = new Todo($connection);





?>