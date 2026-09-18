<h3>Editar Variante de: <?php echo htmlspecialchars($producto['nombre']); ?></h3>

<div class="card" style="max-width: 500px;">
    <form action="?c=Admin&a=variante_edit&id=<?php echo $variante['id']; ?>&producto_id=<?php echo $producto['id']; ?>" method="POST">
        
        <div class="form-group">
            <label>Talle:</label>
            <input type="text" name="talle" class="form-control" value="<?php echo htmlspecialchars($variante['talle']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Color:</label>
            <input type="text" name="color" class="form-control" value="<?php echo htmlspecialchars($variante['color']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" value="<?php echo $variante['stock']; ?>" min="0" required>
        </div>
        
        <div class="form-group">
            <label>SKU (Código único):</label>
            <input type="text" name="sku" class="form-control" value="<?php echo htmlspecialchars($variante['sku']); ?>">
        </div>
        
        <button type="submit" class="btn btn-success">Actualizar Variante</button>
        <a href="?c=Admin&a=variantes&producto_id=<?php echo $producto['id']; ?>" class="btn" style="background:#95a5a6;">Cancelar</a>
    </form>
</div>
