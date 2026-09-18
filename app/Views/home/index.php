<style>
    /* Hero Section */
    .hero {
        text-align: center;
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }
    .hero h1 {
        font-size: 48px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 15px;
        letter-spacing: -2px;
    }
    .hero p {
        font-size: 18px;
        color: var(--text-gray);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Product Grid */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    /* Product Card */
    .product-card {
        background: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid #f1f2f6;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .product-img-wrap {
        height: 250px;
        background: #f1f2f6;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .product-img-wrap img {
        width: 80%;
        height: auto;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img-wrap img {
        transform: scale(1.1) rotate(-5deg);
    }

    .product-info {
        padding: 20px;
    }

    .product-brand {
        font-size: 12px;
        text-transform: uppercase;
        color: var(--text-gray);
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .product-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 22px;
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 20px;
    }

    .btn-block {
        display: block;
        text-align: center;
        width: 100%;
        background: #f8f9fa;
        color: var(--primary);
        border: 1px solid #eee;
    }
    
    .product-card:hover .btn-block {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
</style>

<div class="hero">
    <h1>Lleva tu rendimiento al siguiente nivel.</h1>
    <p>Descubre la nueva colección de calzado deportivo diseñada para velocidad, confort y estilo absoluto.</p>
</div>

<h2 style="margin-bottom: 30px; font-weight: 800; border-left: 5px solid var(--accent); padding-left: 15px;">Catálogo Destacado</h2>

<div class="grid">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $p): ?>
            <div class="product-card">
                <div class="product-img-wrap">
                    <?php if ($p['imagen_principal']): ?>
                        <img src="public/assets/img/<?php echo htmlspecialchars($p['imagen_principal']); ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
                    <?php else: ?>
                        <!-- Imagen placeholder estilo wireframe si no hay imagen -->
                        <div style="color: #ccc; font-weight: bold; font-size: 24px;">SNEAKERX</div>
                    <?php endif; ?>
                </div>
                
                <div class="product-info">
                    <div class="product-brand"><?php echo htmlspecialchars($p['marca']); ?></div>
                    <div class="product-title"><?php echo htmlspecialchars($p['nombre']); ?></div>
                    <div class="product-price">$<?php echo number_format($p['precio'], 2, ',', '.'); ?></div>
                    
                    <a href="?c=Home&a=producto&id=<?php echo $p['id']; ?>" class="btn btn-block">Ver Detalles</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; grid-column: 1 / -1; color: var(--text-gray); padding: 50px;">No hay productos disponibles en este momento.</p>
    <?php endif; ?>
</div>
