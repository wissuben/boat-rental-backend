<?php
require_once '../config/database.php';
require_once '../models/Auth.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($_GET['action'] === 'login') {
            $response = $auth->login($data['email'], $data['password']);
            echo json_encode($response ? $response : ['message' => 'Invalid credentials.']);
        } elseif ($_GET['action'] === 'register') {
            if ($auth->register($data['email'], $data['password'])) {
                echo json_encode(['message' => 'Registration successful.']);
            } else {
                echo json_encode(['message' => 'Registration failed.']);
            }
        }
        break;
}
