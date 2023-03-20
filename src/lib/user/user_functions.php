<?php
require_once(__DIR__ . "/../functions.php");
require_once(__DIR__ . "/../../../vendor/autoload.php");
require_once(__DIR__ . "/../config.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function logged_in($redirect = false, $destination = "login.php") {
    $isLoggedIn = false;

    if (isset($_COOKIE["jwt"]) && !empty($_COOKIE["jwt"])) {
        $jwt = $_COOKIE["jwt"];
        $decoded = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $jwt)[1]))), true);
        if (isset($decoded['exp']) && $decoded['exp'] > time()) {
            $isLoggedIn = true;
        } else {
            // Token has expired or is invalid
            unset($_COOKIE["jwt"]);
            setcookie("jwt", "", -1, "/");
        }
    }
    if ($redirect && !$isLoggedIn) {
        redirect($destination);
    }

    return $isLoggedIn;
}

function get_user_id(){
    $user_id = null;
    if (logged_in()) {
        $jwt = $_COOKIE["jwt"];
        $key = JWT_SECRET;
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $user_id = $decoded->userid;
    }
    return $user_id;
}

function get_credentials($user_id,$rbMQc){
    $user_cred = array();
    $user_cred['type'] = 'user_cred';
    $user_cred['user_id'] = (int)$user_id;

    $response = json_decode($rbMQc->send_request('user_cred'), true);

    switch ($response['code']) {
        case 200:
            return $response;
        case 401:
            $error_msg = 'Unauthorized: ' . $response['message'];
            error_log($error_msg);
            throw new Exception($error_msg);
        default:
            $error_msg = 'Unexpected response code from server: ' . $response['code'] . ' ' . $response['message'];
            error_log($error_msg);
            throw new Exception($error_msg);
    }

}