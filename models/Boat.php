<?php
class Boat {
    private $conn;
    private $table = "boats";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (name, location, type, price, image, availableFrom, availableUntil) 
                  VALUES (:name, :location, :type, :price, :image, :availableFrom, :availableUntil)";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET 
                  name = :name, location = :location, type = :type, price = :price, 
                  image = :image, availableFrom = :availableFrom, availableUntil = :availableUntil
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
