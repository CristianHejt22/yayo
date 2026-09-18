<style>
    .cart-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .cart-items {
        flex: 2;
        min-width: 300px;
    }
    
    .cart-summary {
        flex: 1;
        min-width: 300px;
        background: var(--card-bg);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        background: var(--card-bg);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        gap: 20px;
    }

    .cart-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .cart-item-details {
        flex: 1;
    }

    .cart-item-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .cart-item-variant {
        color: var(--text-gray);
        font-size: 14px;
        margin-bottom: 10px;
    }

    .cart-item-price {
        font-size: 18px;
        font-weight: bold;
        color: var(--accent);
    }

    .qty-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        background: #f1f2f6;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    
    .qty-btn:hover {
        background: #dfe4ea;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    .remove-btn {
        background: none;
        border: none;
        color: #ff4757;
        cursor: pointer;
        font-size: 14px;
        text-decoration: underline;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .summary-total {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary);
        border-top: 2px solid #f1f2f6;
        padding-top: 15px;
        margin-top: 15px;
    }

    .checkout-btn {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        margin-top: 20px;
        background: #2ecc71;
    }
    
    .checkout-btn:hover {
        background: #27ae60;
    }
</style>

<h1 style="margin-bottom: 30px; font-weight: 800;">Tu Carrito</h1>

<div class="cart-container">
    <div class="cart-items">
        <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item" id="item-<?php echo $item['variante_id']; ?>">
                    <?php if ($item['imagen']): ?>
                        <img src="public/assets/img/<?php echo htmlspecialchars($item['imagen']); ?>" alt="img">
                    <?php else: ?>
                        <div style="width: 100px; height: 100px; background: #eee; display: flex; align-items:center; justify-content:center; border-radius:8px;">SNK</div>
                    <?php endif; ?>
                    
                    <div class="cart-item-details">
                        <div class="cart-item-title"><?php echo htmlspecialchars($item['producto_nombre']); ?></div>
                        <div class="cart-item-variant">Talle: <?php echo htmlspecialchars($item['talle']); ?> | Color: <?php echo htmlspecialchars($item['color']); ?></div>
                        <button class="remove-btn" onclick="removeItem(<?php echo $item['variante_id']; ?>)">Eliminar</button>
                    </div>
                    
                    <div>
                        <div class="cart-item-price">$<?php echo number_format($item['precio'], 2, ',', '.'); ?></div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(<?php echo $item['variante_id']; ?>, -1, <?php echo $item['stock_disponible']; ?>)">-</button>
                            <input type="number" class="qty-input" id="qty-<?php echo $item['variante_id']; ?>" value="<?php echo $item['cantidad']; ?>" readonly>
                            <button class="qty-btn" onclick="updateQty(<?php echo $item['variante_id']; ?>, 1, <?php echo $item['stock_disponible']; ?>)">+</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; background: var(--card-bg); border-radius: 12px;">
                <h3 style="color: var(--text-gray); margin-bottom: 20px;">Tu carrito está vacío</h3>
                <a href="?c=Home&a=index" class="btn">Continuar Comprando</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($cart_items)): ?>
    <div class="cart-summary">
        <h3 style="margin-bottom: 20px;">Resumen</h3>
        
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="summary-subtotal">$<?php 
                $total = 0; 
                foreach($cart_items as $i) $total += $i['subtotal']; 
                echo number_format($total, 2, ',', '.'); 
            ?></span>
        </div>
        <div class="summary-row">
            <span>Envío</span>
            <span style="color: #2ecc71;">Gratis</span>
        </div>
        
        <div class="summary-row summary-total">
            <span>Total</span>
            <span id="summary-total">$<?php echo number_format($total, 2, ',', '.'); ?></span>
        </div>
        
        <a href="?c=Checkout&a=index" class="btn checkout-btn">PROCEDER AL PAGO</a>
    </div>
    <?php endif; ?>
</div>

<script>
    function updateQty(varianteId, change, maxStock) {
        const input = document.getElementById('qty-' + varianteId);
        let newQty = parseInt(input.value) + change;
        
        if (newQty < 1) return; // Use removeItem instead if 0
        if (newQty > maxStock) {
            alert("No hay suficiente stock. Máximo disponible: " + maxStock);
            return;
        }
        
        input.value = newQty; // UI Optimistic update
        
        fetch('?c=Cart&a=update', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ variante_id: varianteId, cantidad: newQty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.cart-count').innerText = data.cart_count;
                // Actualizar total (idealmente se formatea bien en JS o se recarga)
                location.reload(); // Recarga simple para mantener sincronizado por ahora
            } else {
                alert(data.message);
                location.reload();
            }
        });
    }

    function removeItem(varianteId) {
        if(confirm('¿Eliminar producto del carrito?')) {
            fetch('?c=Cart&a=remove', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ variante_id: varianteId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>
