<?php
    //Setting upheaders
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    //Delete user
    if($user->delete()){
        echo json_encode(array('message' => 'User deleted.'));
    }else{
        echo json_encode(array('message' => 'User not deleted.'));
    }