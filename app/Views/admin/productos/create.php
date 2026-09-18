<h3>Crear Nuevo Producto</h3>

<div class="card" style="max-width: 600px;">
    <form action="?c=Admin&a=producto_create" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Marca:</label>
            <input type="text" name="marca" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Estado de Publicación:</label>
            <select name="estado_publicacion" class="form-control">
                <option value="activo">Activo</option>
                <option value="pausado">Pausado</option>
                <option value="oculto">Oculto</option>
            </select>
        </div>

        <div class="form-group">
            <label>Imagen Principal:</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-success">Guardar Producto</button>
        <a href="?c=Admin&a=productos" class="btn" style="background:#95a5a6;">Cancelar</a>
    </form>
</div>
