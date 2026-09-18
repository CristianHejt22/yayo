<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Detalle del Pedido #<?php echo $pedido['id']; ?></h3>
    <a href="?c=Admin&a=pedidos" class="btn" style="background:#95a5a6;">Volver a Pedidos</a>
</div>

<div style="display: flex; gap: 20px;">
    <!-- Detalles Generales -->
    <div class="card" style="flex: 1;">
        <h4>Datos del Cliente</h4>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($pedido['cliente_nombre']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($pedido['cliente_email']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($pedido['telefono']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['direccion']); ?>, <?php echo htmlspecialchars($pedido['localidad']); ?></p>
        <hr>
        <h4>Resumen de Compra</h4>
        <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></p>
        <p><strong>Total:</strong> <span style="font-size: 18px; font-weight: bold; color: #2ecc71;">$<?php echo number_format($pedido['total'], 2, ',', '.'); ?></span></p>
        <p><strong>Método de Pago:</strong> <?php echo ucfirst($pedido['metodo_pago']); ?></p>
        <?php if ($pedido['datos_extra']): ?>
            <p><strong>Datos Extra:</strong> <br><small><?php echo nl2br(htmlspecialchars($pedido['datos_extra'])); ?></small></p>
        <?php endif; ?>
    </div>

    <!-- Gestión de Estados -->
    <div class="card" style="flex: 1;">
        <h4>Gestionar Estados</h4>
        
        <form action="?c=Admin&a=pedido_detalle&id=<?php echo $pedido['id']; ?>" method="POST" style="margin-bottom: 20px;">
            <div class="form-group">
                <label>Estado del Pago:</label>
                <select name="estado_pago" class="form-control">
                    <option value="pendiente" <?php echo $pedido['estado_pago'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="pagado" <?php echo $pedido['estado_pago'] == 'pagado' ? 'selected' : ''; ?>>Pagado</option>
                    <option value="rechazado" <?php echo $pedido['estado_pago'] == 'rechazado' ? 'selected' : ''; ?>>Rechazado</option>
                    <option value="cancelado" <?php echo $pedido['estado_pago'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Pago</button>
        </form>

        <form action="?c=Admin&a=pedido_detalle&id=<?php echo $pedido['id']; ?>" method="POST">
            <div class="form-group">
                <label>Estado del Envío:</label>
                <select name="estado_envio" class="form-control">
                    <option value="preparacion" <?php echo $pedido['estado_envio'] == 'preparacion' ? 'selected' : ''; ?>>En Preparación</option>
                    <option value="despachado" <?php echo $pedido['estado_envio'] == 'despachado' ? 'selected' : ''; ?>>Despachado</option>
                    <option value="entregado" <?php echo $pedido['estado_envio'] == 'entregado' ? 'selected' : ''; ?>>Entregado</option>
                    <option value="retira_local" <?php echo $pedido['estado_envio'] == 'retira_local' ? 'selected' : ''; ?>>Retira por Local</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Envío</button>
        </form>
    </div>
</div>

<!-- Ítems del Pedido -->
<div class="card" style="margin-top: 20px;">
    <h4>Productos Adquiridos</h4>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Variante (Talle/Color)</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?php if ($item['imagen_principal']): ?>
                        <img src="public/assets/img/<?php echo htmlspecialchars($item['imagen_principal']); ?>" width="40" style="vertical-align: middle; margin-right: 10px;">
                    <?php endif; ?>
                    <?php echo htmlspecialchars($item['producto_nombre']); ?>
                </td>
                <td>Talle: <?php echo htmlspecialchars($item['talle']); ?> | Color: <?php echo htmlspecialchars($item['color']); ?></td>
                <td>$<?php echo number_format($item['precio_unitario'], 2, ',', '.'); ?></td>
                <td><?php echo $item['cantidad']; ?></td>
                <td>$<?php echo number_format($item['precio_unitario'] * $item['cantidad'], 2, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
