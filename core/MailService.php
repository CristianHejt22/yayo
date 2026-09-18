<?php
// core/MailService.php

class MailService {
    
    public static function sendOrderConfirmation($emailTo, $nombreCliente, $pedidoId, $total, $items) {
        $subject = "Confirmación de Pedido #" . $pedidoId . " - Tienda Calzado";
        
        // Plantilla HTML
        $message = "
        <html>
        <head>
            <title>Confirmación de Pedido</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
            <div style='background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #2ecc71;'>¡Gracias por tu compra, $nombreCliente!</h2>
                <p>Hemos recibido tu pedido <strong>#$pedidoId</strong> y ya estamos trabajando en él.</p>
                
                <h3>Resumen de la compra:</h3>
                <ul style='list-style-type: none; padding: 0;'>";
                
        foreach($items as $item) {
            $message .= "<li style='padding: 10px 0; border-bottom: 1px solid #eee;'>";
            $message .= "<strong>" . $item['titulo'] . "</strong><br>";
            $message .= "Cantidad: " . $item['cantidad'] . " | Precio: $" . number_format($item['precio_unitario'], 2, ',', '.') . "";
            $message .= "</li>";
        }

        $message .= "
                </ul>
                <h3 style='text-align: right; margin-top: 20px;'>Total: $" . number_format($total, 2, ',', '.') . "</h3>
                
                <p style='margin-top: 30px; font-size: 12px; color: #888;'>
                    Este es un correo automático, por favor no respondas a esta dirección.
                </p>
            </div>
        </body>
        </html>
        ";

        // Cabeceras para enviar email HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <ventas@tienda-calzado.local>' . "\r\n";

        // Descomentar para enviar realmente por PHP mail()
        // mail($emailTo, $subject, $message, $headers);
        
        // Por ahora lo guardamos en un log para que lo puedas ver funcionando en local
        $logContent = "=========================================================\n";
        $logContent .= "TO: $emailTo\n";
        $logContent .= "SUBJECT: $subject\n";
        $logContent .= "DATE: " . date('Y-m-d H:i:s') . "\n";
        $logContent .= "BODY:\n" . strip_tags(str_replace(['<br>', '</li>', '</h3>'], "\n", $message)) . "\n";
        $logContent .= "=========================================================\n\n";
        
        file_put_contents('emails_sent_log.txt', $logContent, FILE_APPEND);
        
        return true;
    }
}
?>
