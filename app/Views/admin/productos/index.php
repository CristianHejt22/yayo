<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Listado de Productos</h3>
    <a href="?c=Admin&a=producto_create" class="btn btn-success">+ Nuevo Producto</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td>
                        <?php if ($p['imagen_principal']): ?>
                            <img src="public/assets/img/<?php echo htmlspecialchars($p['imagen_principal']); ?>" width="50" alt="img">
                        <?php else: ?>
                            Sin imagen
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($p['marca']); ?></td>
                    <td>$<?php echo number_format($p['precio'], 2, ',', '.'); ?></td>
                    <td><?php echo ucfirst($p['estado_publicacion']); ?></td>
                    <td>
                        <a href="?c=Admin&a=variantes&producto_id=<?php echo $p['id']; ?>" class="btn btn-success" style="padding:5px 10px; font-size:12px;">Variantes</a>
                        <a href="?c=Admin&a=producto_edit&id=<?php echo $p['id']; ?>" class="btn" style="background:#f39c12; padding:5px 10px; font-size:12px;">Editar</a>
                        <a href="?c=Admin&a=producto_delete&id=<?php echo $p['id']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
