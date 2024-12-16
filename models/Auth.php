<?php
require_once __DIR__ . '/../utils/jwt.php';

class Auth {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($email, $password) {
        $query = "INSERT INTO " . $this->table . " (email, password) VALUES (:email, :password)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT id, password FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $token = JWT::encode(['id' => $user['id']], 'secret_key');
            return ['token' => $token];
        }
        return false;
    }
}
