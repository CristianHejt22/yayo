<?php
// app/Models/ProductoModel.php

class ProductoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductos() {
        $query = "SELECT * FROM productos ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductoById($id) {
        $query = "SELECT * FROM productos WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createProducto($data) {
        $query = "INSERT INTO productos (nombre, marca, descripcion, precio, estado_publicacion, imagen_principal) 
                  VALUES (:nombre, :marca, :descripcion, :precio, :estado_publicacion, :imagen_principal)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':marca', $data['marca']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':estado_publicacion', $data['estado_publicacion']);
        $stmt->bindParam(':imagen_principal', $data['imagen_principal']);
        
        return $stmt->execute();
    }

    public function updateProducto($id, $data) {
        $query = "UPDATE productos SET 
                  nombre = :nombre, 
                  marca = :marca, 
                  descripcion = :descripcion, 
                  precio = :precio, 
                  estado_publicacion = :estado_publicacion";
        
        if (!empty($data['imagen_principal'])) {
            $query .= ", imagen_principal = :imagen_principal";
        }
        
        $query .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':marca', $data['marca']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':estado_publicacion', $data['estado_publicacion']);
        $stmt->bindParam(':id', $id);
        
        if (!empty($data['imagen_principal'])) {
            $stmt->bindParam(':imagen_principal', $data['imagen_principal']);
        }
        
        return $stmt->execute();
    }

    public function deleteProducto($id) {
        $query = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
