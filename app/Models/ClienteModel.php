<?php
// app/Models/ClienteModel.php

class ClienteModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getClienteByEmail($email) {
        $query = "SELECT * FROM clientes WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createCliente($data) {
        $query = "INSERT INTO clientes (nombre, email, telefono, direccion, localidad) 
                  VALUES (:nombre, :email, :telefono, :direccion, :localidad)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':localidad', $data['localidad']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updateCliente($id, $data) {
        $query = "UPDATE clientes SET 
                  nombre = :nombre, 
                  telefono = :telefono, 
                  direccion = :direccion, 
                  localidad = :localidad 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':localidad', $data['localidad']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>
