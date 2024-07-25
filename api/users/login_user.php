<?php
//Setting up headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require '../../vendor/autoload.php';
include_once '../../config/Database.php';
include_once '../../config/core.php';
include_once '../../models/User.php';

include_once "../../vendor/firebase/php-jwt/src/BeforeValidException.php";
include_once "../../vendor/firebase/php-jwt/src/ExpiredException.php";
include_once "../../vendor/firebase/php-jwt/src/SignatureInvalidException.php";
include_once "../../vendor/firebase/php-jwt/src/JWT.php";
use \Firebase\JWT\JWT;


//Connecting to database
$database = new Database();
$db = $database->connect();

//Creating User object
$user = new User($db);

//Get the data from User method
$data = json_decode(file_get_contents('php://input'));
$user->email = $data->email;
$email_exists = $user->emailExists();

if ($email_exists && password_verify($data->password, $user->password)) {

    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        )
    );

    http_response_code(200);

    // Create jwt
    $jwt = JWT::encode($token, $key, 'HS256');
    echo json_encode(
        array(
            "message" => "Успешный вход в систему",
            "jwt" => $jwt
        )
    );
}

else {
    http_response_code(401);
    echo json_encode(array("message" => "Ошибка входа"));
}
