<?php
// app/Controllers/WebhookController.php

require_once 'core/Controller.php';

class WebhookController extends Controller {
    
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = $this->model('PedidoModel');
    }

    public function mercadopago() {
        // MercadoPago envía las notificaciones vía POST/GET
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Guardar un log para debug
        file_put_contents('mp_webhook_log.txt', print_r($data, true) . "\n\n", FILE_APPEND);

        // Validar si es una notificación de pago
        if (isset($_GET['topic']) && $_GET['topic'] == 'payment') {
            $payment_id = $_GET['id'];
            
            // Consultar el estado real del pago a la API de MercadoPago
            $access_token = "TEST-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
            
            $ch = curl_init('https://api.mercadopago.com/v1/payments/' . $payment_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token
            ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $payment_info = json_decode($response, true);
            
            if (isset($payment_info['status'])) {
                $status = $payment_info['status'];
                $external_reference = $payment_info['external_reference']; // Este es nuestro pedido_id
                
                // Actualizar estado en nuestra base de datos
                if ($status == 'approved') {
                    // Pago aprobado
                    $this->pedidoModel->updateEstadoEnvio($external_reference, 'pagado');
                } else if ($status == 'rejected') {
                    // Pago rechazado
                    $this->pedidoModel->updateEstadoEnvio($external_reference, 'cancelado');
                }
            }
        }
        
        // MercadoPago exige responder HTTP 200 OK
        http_response_code(200);
        echo "OK";
    }
}
?>
