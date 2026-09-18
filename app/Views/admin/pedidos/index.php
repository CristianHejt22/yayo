<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3>Listado de Pedidos</h3>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Método Pago</th>
                <th>Estado Pago</th>
                <th>Estado Envío</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pedidos)): ?>
                <?php foreach ($pedidos as $p): ?>
                <tr>
                    <td>#<?php echo $p['id']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
                    <td>
                        <?php echo htmlspecialchars($p['cliente_nombre']); ?><br>
                        <small style="color: #7f8c8d;"><?php echo htmlspecialchars($p['cliente_email']); ?></small>
                    </td>
                    <td>$<?php echo number_format($p['total'], 2, ',', '.'); ?></td>
                    <td><?php echo ucfirst($p['metodo_pago']); ?></td>
                    <td>
                        <?php
                        $colorPago = '#95a5a6'; // pendiente
                        if ($p['estado_pago'] == 'pagado') $colorPago = '#2ecc71';
                        if ($p['estado_pago'] == 'rechazado' || $p['estado_pago'] == 'cancelado') $colorPago = '#e74c3c';
                        ?>
                        <span style="background-color: <?php echo $colorPago; ?>; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">
                            <?php echo ucfirst($p['estado_pago']); ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        $colorEnvio = '#f39c12'; // preparacion
                        if ($p['estado_envio'] == 'despachado' || $p['estado_envio'] == 'entregado' || $p['estado_envio'] == 'retira_local') $colorEnvio = '#3498db';
                        ?>
                        <span style="background-color: <?php echo $colorEnvio; ?>; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">
                            <?php echo ucfirst(str_replace('_', ' ', $p['estado_envio'])); ?>
                        </span>
                    </td>
                    <td>
                        <a href="?c=Admin&a=pedido_detalle&id=<?php echo $p['id']; ?>" class="btn" style="background:#34495e; padding:5px 10px; font-size:12px;">Ver / Gestionar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No hay pedidos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
