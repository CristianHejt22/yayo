<?php
// app/Controllers/CheckoutController.php

require_once 'core/Controller.php';

class CheckoutController extends Controller {
    
    private $productoModel;
    private $varianteModel;
    private $clienteModel;
    private $pedidoModel;

    public function __construct() {
        $this->productoModel = $this->model('ProductoModel');
        $this->varianteModel = $this->model('VarianteModel');
        $this->clienteModel = $this->model('ClienteModel');
        $this->pedidoModel = $this->model('PedidoModel');
        
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: ?c=Cart&a=index');
            exit;
        }
    }

    public function index() {
        $this->view('home/checkout');
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?c=Cart&a=index');
            exit;
        }

        // 1. Guardar/Actualizar Cliente
        $clienteData = [
            'nombre' => $_POST['nombre'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'localidad' => $_POST['localidad'] ?? ''
        ];

        $cliente_id = null;
        $existente = $this->clienteModel->getClienteByEmail($clienteData['email']);
        
        if ($existente) {
            $cliente_id = $existente['id'];
            $this->clienteModel->updateCliente($cliente_id, $clienteData);
        } else {
            $cliente_id = $this->clienteModel->createCliente($clienteData);
        }

        if (!$cliente_id) {
            die("Error al procesar datos del cliente.");
        }

        // 2. Calcular Total y Armar Items
        $total = 0;
        $items_pedido = [];
        
        foreach ($_SESSION['cart'] as $item) {
            $producto = $this->productoModel->getProductoById($item['producto_id']);
            $variante = $this->varianteModel->getVarianteById($item['variante_id']);
            
            if ($producto && $variante && $variante['stock'] >= $item['cantidad']) {
                $subtotal = $producto['precio'] * $item['cantidad'];
                $total += $subtotal;
                
                $items_pedido[] = [
                    'variante_id' => $variante['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto['precio'],
                    'titulo' => $producto['nombre'] . ' (' . $variante['talle'] . '/' . $variante['color'] . ')'
                ];
            } else {
                die("Error: Stock insuficiente para " . $producto['nombre']);
            }
        }

        // 3. Crear Pedido en DB (Pendiente)
        $metodo_pago = $_POST['metodo_pago'] ?? 'transferencia';
        $pedido_id = $this->pedidoModel->createPedido($cliente_id, $total, $metodo_pago);

        if (!$pedido_id) {
            die("Error al crear el pedido.");
        }

        foreach ($items_pedido as $ip) {
            $this->pedidoModel->addPedidoItem($pedido_id, $ip['variante_id'], $ip['cantidad'], $ip['precio_unitario']);
            
            // Restar stock
            $v = $this->varianteModel->getVarianteById($ip['variante_id']);
            $nuevo_stock = $v['stock'] - $ip['cantidad'];
            $this->varianteModel->updateVariante($ip['variante_id'], [
                'talle' => $v['talle'], 'color' => $v['color'], 'sku' => $v['sku'], 'stock' => $nuevo_stock
            ]);
        }

        // Limpiar carrito
        $_SESSION['cart'] = [];

        // 4. Enviar email de confirmación
        require_once 'core/MailService.php';
        MailService::sendOrderConfirmation($clienteData['email'], $clienteData['nombre'], $pedido_id, $total, $items_pedido);

        // 5. Lógica según método de pago
        if ($metodo_pago === 'mercadopago') {
            // Generar link de pago simulado/real con cURL
            $this->procesarMercadoPago($pedido_id, $total, $items_pedido, $clienteData);
        } else {
            // Transferencia o Efectivo
            header('Location: ?c=Checkout&a=success&id=' . $pedido_id);
            exit;
        }
    }

    private function procesarMercadoPago($pedido_id, $total, $items_pedido, $clienteData) {
        // NOTA: Reemplazar con ACCESS_TOKEN real de Mercado Pago
        $access_token = "TEST-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
        
        // Items para MP
        $items_mp = [];
        foreach ($items_pedido as $ip) {
            $items_mp[] = [
                "title" => $ip['titulo'],
                "quantity" => (int)$ip['cantidad'],
                "unit_price" => (float)$ip['precio_unitario'],
                "currency_id" => "ARS"
            ];
        }

        $preference_data = [
            "items" => $items_mp,
            "payer" => [
                "name" => $clienteData['nombre'],
                "email" => $clienteData['email']
            ],
            "back_urls" => [
                "success" => "http://" . $_SERVER['HTTP_HOST'] . "/tienda-calzado/?c=Checkout&a=success&id=" . $pedido_id,
                "failure" => "http://" . $_SERVER['HTTP_HOST'] . "/tienda-calzado/?c=Checkout&a=failure",
                "pending" => "http://" . $_SERVER['HTTP_HOST'] . "/tienda-calzado/?c=Checkout&a=success&id=" . $pedido_id
            ],
            "auto_return" => "approved",
            "external_reference" => (string)$pedido_id,
            // URL a donde MercadoPago enviará POST con actualizaciones (Webhook)
            "notification_url" => "http://" . $_SERVER['HTTP_HOST'] . "/tienda-calzado/?c=Webhook&a=mercadopago" 
        ];

        $ch = curl_init('https://api.mercadopago.com/checkout/preferences');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preference_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($response, true);

        if (isset($res['init_point'])) {
            // Redirigir al usuario al Checkout Pro de Mercado Pago
            header('Location: ' . $res['init_point']);
            exit;
        } else {
            // Fallback en caso de error (credenciales inválidas, etc)
            echo "Error al conectar con Mercado Pago. Revisa el Access Token.";
            echo "<pre>"; print_r($res); echo "</pre>";
        }
    }

    public function success() {
        $id = $_GET['id'] ?? null;
        $this->view('home/success', ['pedido_id' => $id]);
    }
}
?>
