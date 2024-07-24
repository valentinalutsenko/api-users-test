<?php
//Setting up headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

//Connecting to database
$database = new Database();
$db = $database->connect();

//Creating User object
$user = new User($db);

$user->id = isset($_GET['id']) ?? die();

$row = $user->get_item($user->query_get_user);

$user_arr = array(
    'id' => $row['id'],
    'name' => $row['name'],
    'email' => $row['email'],
);

//Create JSON
print_r(json_encode($user_arr));