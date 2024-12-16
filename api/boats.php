<?php
require_once '../config/database.php';
require_once '../models/Boat.php';

$database = new Database();
$db = $database->getConnection();
$boat = new Boat($db);

header("Content-Type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $response = $boat->get($_GET['id']);
        } else {
            $response = $boat->getAll();
        }
        echo json_encode($response);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($boat->create($data)) {
            echo json_encode(["message" => "Boat created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create boat."]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $data);
        if ($boat->update($data['id'], $data)) {
            echo json_encode(["message" => "Boat updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update boat."]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        if ($boat->delete($data['id'])) {
            echo json_encode(["message" => "Boat deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete boat."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request."]);
        break;
}
