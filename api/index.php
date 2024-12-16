<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$resource = isset($requestUri[1]) ? $requestUri[1] : null;

switch ($resource) {
    case 'auth':
        require_once 'auth.php';
        break;

    case 'boats':
        require_once 'boats.php';
        break;

    case 'reservations':
        require_once 'reservations.php';
        break;

    default:
        echo json_encode(["message" => "Invalid endpoint."]);
        break;
}
