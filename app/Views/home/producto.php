<style>
    .product-detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 50px;
        background: var(--card-bg);
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .product-gallery {
        flex: 1;
        min-width: 300px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .product-gallery img {
        max-width: 100%;
        height: auto;
        transform: rotate(-10deg);
        filter: drop-shadow(0 20px 20px rgba(0,0,0,0.15));
    }

    .product-details {
        flex: 1;
        min-width: 300px;
    }

    .breadcrumb {
        color: var(--text-gray);
        font-size: 14px;
        margin-bottom: 20px;
    }
    .breadcrumb a {
        color: var(--text-gray);
        text-decoration: none;
    }

    .pd-brand {
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--accent);
        font-weight: 800;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .pd-title {
        font-size: 36px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--primary);
    }

    .pd-price {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 30px;
    }

    .pd-description {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 30px;
        font-size: 16px;
    }

    /* Variant Selector */
    .variant-selector {
        margin-bottom: 30px;
    }
    
    .variant-label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .size-btn {
        display: inline-block;
        padding: 10px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 4px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        background: white;
    }

    .size-btn:hover {
        border-color: var(--primary);
    }

    .size-btn.selected {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .size-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 18px;
        font-size: 18px;
        margin-top: 20px;
    }
</style>

<div class="product-detail-container">
    
    <div class="product-gallery">
        <?php if ($producto['imagen_principal']): ?>
            <img src="public/assets/img/<?php echo htmlspecialchars($producto['imagen_principal']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <?php else: ?>
            <div style="font-size: 40px; font-weight: 800; color: #ddd;">SNEAKERX</div>
        <?php endif; ?>
    </div>

    <div class="product-details">
        <div class="breadcrumb">
            <a href="?c=Home&a=index">Inicio</a> / <a href="#"><?php echo htmlspecialchars($producto['marca']); ?></a> / <?php echo htmlspecialchars($producto['nombre']); ?>
        </div>
        
        <div class="pd-brand"><?php echo htmlspecialchars($producto['marca']); ?></div>
        <h1 class="pd-title"><?php echo htmlspecialchars($producto['nombre']); ?></h1>
        <div class="pd-price">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></div>
        
        <p class="pd-description">
            <?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?>
        </p>

        <!-- Formulario para agregar al carrito -->
        <form id="add-to-cart-form">
            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
            <input type="hidden" name="variante_id" id="variante_id" value="">
            
            <div class="variant-selector">
                <span class="variant-label">Selecciona tu Talle (Color):</span>
                <div>
                    <?php if (!empty($variantes)): ?>
                        <?php foreach ($variantes as $v): ?>
                            <?php 
                                $isAvailable = $v['stock'] > 0;
                                $class = $isAvailable ? 'size-btn' : 'size-btn disabled';
                            ?>
                            <button type="button" class="<?php echo $class; ?>" 
                                    <?php echo !$isAvailable ? 'disabled' : ''; ?>
                                    onclick="selectVariant(this, <?php echo $v['id']; ?>)">
                                <?php echo htmlspecialchars($v['talle']); ?> - <?php echo htmlspecialchars($v['color']); ?>
                            </button>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: red; font-weight: bold;">Sin stock disponible actualmente.</p>
                    <?php endif; ?>
                </div>
                <div id="variant-error" style="color: var(--accent); margin-top: 10px; display: none;">
                    Por favor, selecciona un talle antes de continuar.
                </div>
            </div>

            <button type="button" class="btn add-to-cart-btn" onclick="addToCart()">AÑADIR AL CARRITO</button>
        </form>
    </div>

</div>

<script>
    function selectVariant(button, varianteId) {
        // Quitar selección previa
        document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
        // Marcar el actual
        button.classList.add('selected');
        // Asignar al input hidden
        document.getElementById('variante_id').value = varianteId;
        document.getElementById('variant-error').style.display = 'none';
    }

    function addToCart() {
        const varianteId = document.getElementById('variante_id').value;
        const productoId = document.querySelector('input[name="producto_id"]').value;
        
        if (!varianteId) {
            document.getElementById('variant-error').style.display = 'block';
            return;
        }

        const btn = document.querySelector('.add-to-cart-btn');
        btn.innerHTML = 'Agregando...';
        btn.disabled = true;

        fetch('?c=Cart&a=add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                producto_id: productoId,
                variante_id: varianteId,
                cantidad: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar contador del navbar
                document.querySelector('.cart-count').innerText = data.cart_count;
                btn.innerHTML = '¡AGREGADO!';
                btn.style.backgroundColor = '#2ecc71';
                setTimeout(() => {
                    btn.innerHTML = 'AÑADIR AL CARRITO';
                    btn.style.backgroundColor = 'var(--primary)';
                    btn.disabled = false;
                }, 2000);
            } else {
                alert(data.message || 'Error al agregar al carrito');
                btn.innerHTML = 'AÑADIR AL CARRITO';
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = 'AÑADIR AL CARRITO';
            btn.disabled = false;
        });
    }
</script>
