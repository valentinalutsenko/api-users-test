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
    $users = new User($db);

    //Getting the users
    $result = $users->get_items($users->query_get_users);
    $num = $result->rowCount();

    //Check for users
    if($num > 0){
        $users_arr = array();
        $users_arr['data'] = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $users_item = array(
                'id' => $id,
                'name' => $name,
                'email' => $email,
            );
            array_push($users_arr['data'], $users_item);
        }
        //Turning to JSON and output
        echo json_encode($users_arr);
    }else{
        //If no users
        echo json_encode(array('message' => 'No users available.'));
    }