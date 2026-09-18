<h3>Agregar Variante a: <?php echo htmlspecialchars($producto['nombre']); ?></h3>

<div class="card" style="max-width: 500px;">
    <form action="?c=Admin&a=variante_create&producto_id=<?php echo $producto['id']; ?>" method="POST">
        
        <div class="form-group">
            <label>Talle:</label>
            <input type="text" name="talle" class="form-control" placeholder="Ej: 40, 41, M, L" required>
        </div>
        
        <div class="form-group">
            <label>Color:</label>
            <input type="text" name="color" class="form-control" placeholder="Ej: Negro, Blanco" required>
        </div>
        
        <div class="form-group">
            <label>Stock Inicial:</label>
            <input type="number" name="stock" class="form-control" value="0" min="0" required>
        </div>
        
        <div class="form-group">
            <label>SKU (Código único):</label>
            <input type="text" name="sku" class="form-control" placeholder="Ej: NK-AM270-40N">
        </div>
        
        <button type="submit" class="btn btn-success">Guardar Variante</button>
        <a href="?c=Admin&a=variantes&producto_id=<?php echo $producto['id']; ?>" class="btn" style="background:#95a5a6;">Cancelar</a>
    </form>
</div>
