<style>
    .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .checkout-form {
        flex: 2;
        min-width: 300px;
        background: var(--card-bg);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .checkout-summary {
        flex: 1;
        min-width: 300px;
    }

    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--primary);
    }
    
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    .payment-methods {
        margin-top: 30px;
    }
    
    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .payment-option:hover {
        background: #f8f9fa;
        border-color: var(--primary);
    }
    
    .payment-option input {
        margin-right: 15px;
        transform: scale(1.2);
    }
</style>

<h1 style="margin-bottom: 30px; font-weight: 800;">Finalizar Compra</h1>

<div class="checkout-container">
    <div class="checkout-form">
        <h3 style="margin-bottom: 20px;">Datos de Envío y Facturación</h3>
        
        <form action="?c=Checkout&a=process" method="POST">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 2;">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" class="form-control" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Localidad:</label>
                    <input type="text" name="localidad" class="form-control" required>
                </div>
            </div>

            <div class="payment-methods">
                <h3 style="margin-bottom: 20px;">Método de Pago</h3>
                
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="mercadopago" checked>
                    <div>
                        <strong>Mercado Pago</strong>
                        <div style="color: var(--text-gray); font-size: 14px;">Tarjetas de crédito, débito, dinero en cuenta.</div>
                    </div>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="transferencia">
                    <div>
                        <strong>Transferencia Bancaria</strong>
                        <div style="color: var(--text-gray); font-size: 14px;">Te mostraremos el CBU/Alias al finalizar.</div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="efectivo">
                    <div>
                        <strong>Efectivo</strong>
                        <div style="color: var(--text-gray); font-size: 14px;">Abona en nuestra sucursal.</div>
                    </div>
                </label>
            </div>

            <button type="submit" class="btn" style="width: 100%; margin-top: 30px; padding: 15px; font-size: 16px; background: #2ecc71;">CONFIRMAR PEDIDO</button>
        </form>
    </div>

    <div class="checkout-summary">
        <div class="card" style="position: sticky; top: 100px;">
            <h3 style="margin-bottom: 20px;">Resumen de Compra</h3>
            
            <?php 
                $total = 0;
                foreach($_SESSION['cart'] as $item): 
                    // Necesitamos obtener datos del producto de la BD para mostrarlos
                    // Por simplicidad en la vista, usaremos un truco o mejor calculamos el total simple
                    // En una app más compleja, pasaríamos $cart_items desde el controlador
            ?>
                <!-- Se mostrarían los items aquí si los pasamos -->
            <?php endforeach; ?>
            
            <p><strong>Recuerda revisar bien tus datos antes de continuar.</strong></p>
            <p style="color: var(--text-gray); font-size: 14px; margin-top: 20px;">Al confirmar, aceptarás nuestros términos y condiciones.</p>
        </div>
    </div>
</div>
