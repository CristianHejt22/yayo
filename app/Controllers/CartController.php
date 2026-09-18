<?php
// app/Controllers/CartController.php

require_once 'core/Controller.php';

class CartController extends Controller {
    
    private $productoModel;
    private $varianteModel;

    public function __construct() {
        $this->productoModel = $this->model('ProductoModel');
        $this->varianteModel = $this->model('VarianteModel');
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index() {
        // Vista completa del carrito
        $cart_items = $this->getCartDetails();
        $this->view('home/cart', ['cart_items' => $cart_items]);
    }

    // Endpoint para API Fetch (agregar)
    public function add() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $producto_id = $input['producto_id'] ?? null;
        $variante_id = $input['variante_id'] ?? null;
        $cantidad = $input['cantidad'] ?? 1;

        if (!$producto_id || !$variante_id) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos']);
            return;
        }

        // Verificar stock real
        $variante = $this->varianteModel->getVarianteById($variante_id);
        if (!$variante || $variante['stock'] < $cantidad) {
            echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
            return;
        }

        // Crear un identificador único para el item en el carrito (por si agregamos mismo producto distinta variante)
        $cart_key = $variante_id;

        if (isset($_SESSION['cart'][$cart_key])) {
            // Validar que no se pase del stock al sumar
            $nueva_cantidad = $_SESSION['cart'][$cart_key]['cantidad'] + $cantidad;
            if ($nueva_cantidad > $variante['stock']) {
                echo json_encode(['success' => false, 'message' => 'No puedes agregar más unidades de las disponibles']);
                return;
            }
            $_SESSION['cart'][$cart_key]['cantidad'] = $nueva_cantidad;
        } else {
            $_SESSION['cart'][$cart_key] = [
                'producto_id' => $producto_id,
                'variante_id' => $variante_id,
                'cantidad' => $cantidad
            ];
        }

        echo json_encode([
            'success' => true, 
            'message' => 'Producto agregado al carrito',
            'cart_count' => $this->getCartCount()
        ]);
    }

    // Endpoint para actualizar cantidad
    public function update() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $variante_id = $input['variante_id'] ?? null;
        $cantidad = $input['cantidad'] ?? 1;

        if ($variante_id && isset($_SESSION['cart'][$variante_id])) {
            if ($cantidad > 0) {
                // Verificar stock
                $variante = $this->varianteModel->getVarianteById($variante_id);
                if ($cantidad <= $variante['stock']) {
                    $_SESSION['cart'][$variante_id]['cantidad'] = $cantidad;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
                    return;
                }
            } else {
                unset($_SESSION['cart'][$variante_id]);
            }
        }
        
        echo json_encode([
            'success' => true, 
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->calculateTotal()
        ]);
    }

    // Endpoint para eliminar un item
    public function remove() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $variante_id = $input['variante_id'] ?? null;

        if ($variante_id && isset($_SESSION['cart'][$variante_id])) {
            unset($_SESSION['cart'][$variante_id]);
        }

        echo json_encode([
            'success' => true, 
            'cart_count' => $this->getCartCount()
        ]);
    }

    // Endpoint para obtener conteo total
    public function count() {
        header('Content-Type: application/json');
        echo json_encode(['count' => $this->getCartCount()]);
    }

    // Helpers
    private function getCartCount() {
        $count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['cantidad'];
        }
        return $count;
    }

    private function getCartDetails() {
        $items = [];
        foreach ($_SESSION['cart'] as $key => $item) {
            $producto = $this->productoModel->getProductoById($item['producto_id']);
            $variante = $this->varianteModel->getVarianteById($item['variante_id']);
            
            if ($producto && $variante) {
                $items[] = [
                    'variante_id' => $item['variante_id'],
                    'producto_nombre' => $producto['nombre'],
                    'marca' => $producto['marca'],
                    'imagen' => $producto['imagen_principal'],
                    'talle' => $variante['talle'],
                    'color' => $variante['color'],
                    'precio' => $producto['precio'],
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $producto['precio'] * $item['cantidad'],
                    'stock_disponible' => $variante['stock']
                ];
            }
        }
        return $items;
    }

    private function calculateTotal() {
        $total = 0;
        $items = $this->getCartDetails();
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}
?>
