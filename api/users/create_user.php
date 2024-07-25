<?php
    //Setting up headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    //Connecting to database
    $database = new Database();
    $db = $database->connect();

    //Creating User object
    $user = new User($db);

    //Get the data from User method
    $data = json_decode(file_get_contents('php://input'));
    $user->name = htmlspecialchars(strip_tags($data->name));
    $user->email = htmlspecialchars(strip_tags($data->email));
    $user->password =  md5($data->password);


    //Create user
    if($user->create()){
        echo json_encode(array('message' => 'User created.'));
    }else{
        echo json_encode(array('message' => 'User not created.'));
    }