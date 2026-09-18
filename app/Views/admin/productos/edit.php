<h3>Editar Producto: <?php echo htmlspecialchars($producto['nombre']); ?></h3>

<div class="card" style="max-width: 600px;">
    <form action="?c=Admin&a=producto_edit&id=<?php echo $producto['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Marca:</label>
            <input type="text" name="marca" class="form-control" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Estado de Publicación:</label>
            <select name="estado_publicacion" class="form-control">
                <option value="activo" <?php echo $producto['estado_publicacion'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                <option value="pausado" <?php echo $producto['estado_publicacion'] == 'pausado' ? 'selected' : ''; ?>>Pausado</option>
                <option value="oculto" <?php echo $producto['estado_publicacion'] == 'oculto' ? 'selected' : ''; ?>>Oculto</option>
            </select>
        </div>

        <div class="form-group">
            <label>Imagen Principal (Dejar en blanco para mantener la actual):</label>
            <?php if ($producto['imagen_principal']): ?>
                <div style="margin-bottom: 10px;">
                    <img src="public/assets/img/<?php echo htmlspecialchars($producto['imagen_principal']); ?>" width="100" alt="img actual">
                </div>
            <?php endif; ?>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-success">Actualizar Producto</button>
        <a href="?c=Admin&a=productos" class="btn" style="background:#95a5a6;">Cancelar</a>
    </form>
</div>
