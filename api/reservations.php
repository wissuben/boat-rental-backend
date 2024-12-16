<?php
require_once '../config/database.php';
require_once '../models/Reservation.php';

$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);

header("Content-Type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $response = $reservation->getAll();
        echo json_encode($response);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($reservation->create($data)) {
            echo json_encode(["message" => "Reservation created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create reservation."]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        if ($reservation->delete($data['id'])) {
            echo json_encode(["message" => "Reservation deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete reservation."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
