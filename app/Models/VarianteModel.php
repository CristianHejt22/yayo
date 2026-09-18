<?php
// app/Models/VarianteModel.php

class VarianteModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getVariantesByProducto($producto_id) {
        $query = "SELECT * FROM producto_variantes WHERE producto_id = :producto_id ORDER BY id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getVarianteById($id) {
        $query = "SELECT * FROM producto_variantes WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createVariante($data) {
        $query = "INSERT INTO producto_variantes (producto_id, talle, color, stock, sku) 
                  VALUES (:producto_id, :talle, :color, :stock, :sku)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':producto_id', $data['producto_id']);
        $stmt->bindParam(':talle', $data['talle']);
        $stmt->bindParam(':color', $data['color']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':sku', $data['sku']);
        
        return $stmt->execute();
    }

    public function updateVariante($id, $data) {
        $query = "UPDATE producto_variantes SET 
                  talle = :talle, 
                  color = :color, 
                  stock = :stock, 
                  sku = :sku 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':talle', $data['talle']);
        $stmt->bindParam(':color', $data['color']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function deleteVariante($id) {
        $query = "DELETE FROM producto_variantes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
