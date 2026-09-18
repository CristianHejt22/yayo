<?php
// app/Models/PedidoModel.php

class PedidoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getPedidos() {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.email as cliente_email 
                  FROM pedidos p 
                  JOIN clientes c ON p.cliente_id = c.id 
                  ORDER BY p.fecha_pedido DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPedidoById($id) {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.email as cliente_email, c.telefono, c.direccion, c.localidad 
                  FROM pedidos p 
                  JOIN clientes c ON p.cliente_id = c.id 
                  WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPedidoItems($pedido_id) {
        $query = "SELECT pi.*, v.talle, v.color, pr.nombre as producto_nombre, pr.imagen_principal
                  FROM pedido_items pi
                  JOIN producto_variantes v ON pi.variante_id = v.id
                  JOIN productos pr ON v.producto_id = pr.id
                  WHERE pi.pedido_id = :pedido_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateEstadoPago($id, $estado) {
        $query = "UPDATE pedidos SET estado_pago = :estado WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateEstadoEnvio($id, $estado) {
        $query = "UPDATE pedidos SET estado_envio = :estado WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createPedido($cliente_id, $total, $metodo_pago, $datos_extra = null) {
        $query = "INSERT INTO pedidos (cliente_id, total, metodo_pago, datos_extra) 
                  VALUES (:cliente_id, :total, :metodo_pago, :datos_extra)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':datos_extra', $datos_extra);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function addPedidoItem($pedido_id, $variante_id, $cantidad, $precio_unitario) {
        $query = "INSERT INTO pedido_items (pedido_id, variante_id, cantidad, precio_unitario) 
                  VALUES (:pedido_id, :variante_id, :cantidad, :precio_unitario)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->bindParam(':variante_id', $variante_id);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio_unitario', $precio_unitario);
        return $stmt->execute();
    }
}
?>
