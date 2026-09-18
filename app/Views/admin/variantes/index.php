<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Variantes de: <?php echo htmlspecialchars($producto['nombre']); ?></h3>
    <div>
        <a href="?c=Admin&a=productos" class="btn" style="background:#95a5a6; margin-right: 10px;">Volver</a>
        <a href="?c=Admin&a=variante_create&producto_id=<?php echo $producto['id']; ?>" class="btn btn-success">+ Nueva Variante</a>
    </div>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Talle</th>
                <th>Color</th>
                <th>SKU</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($variantes)): ?>
                <?php foreach ($variantes as $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo htmlspecialchars($v['talle']); ?></td>
                    <td><?php echo htmlspecialchars($v['color']); ?></td>
                    <td><?php echo htmlspecialchars($v['sku']); ?></td>
                    <td>
                        <span style="padding: 3px 8px; border-radius: 3px; color: white; background-color: <?php echo $v['stock'] > 0 ? '#2ecc71' : '#e74c3c'; ?>">
                            <?php echo $v['stock']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="?c=Admin&a=variante_edit&id=<?php echo $v['id']; ?>&producto_id=<?php echo $producto['id']; ?>" class="btn" style="background:#f39c12; padding:5px 10px; font-size:12px;">Editar</a>
                        <a href="?c=Admin&a=variante_delete&id=<?php echo $v['id']; ?>&producto_id=<?php echo $producto['id']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Eliminar esta variante?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay variantes para este producto.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
