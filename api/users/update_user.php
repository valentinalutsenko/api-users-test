<?php
    //Setting up headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    //Connecting to database
    $database = new Database();
    $db = $database->connect();

    //Creating User object
    $user = new User($db);

    //Get the data
    $data = json_decode(file_get_contents('php://input'));

    $user->id = htmlspecialchars(strip_tags($data->id));
    $user->name = htmlspecialchars(strip_tags($data->name));
    $user->email = htmlspecialchars(strip_tags($data->email));
    $user->updated_at = htmlspecialchars(strip_tags($data->updated_at));

    //Update user
    if($user->update()){
        echo json_encode(array('message' => 'User updated.'));
    }else{
        echo json_encode(array('message' => 'User not updated.'));
    }