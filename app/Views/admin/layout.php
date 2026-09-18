<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tienda Calzado</title>
    <!-- CSS Básico Integrado para desarrollo rápido -->
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f6f9; color: #333; }
        .sidebar { width: 250px; background-color: #2c3e50; color: #fff; position: fixed; height: 100%; top: 0; left: 0; padding-top: 20px; }
        .sidebar a { display: block; padding: 15px 20px; color: #ecf0f1; text-decoration: none; border-bottom: 1px solid #34495e; }
        .sidebar a:hover { background-color: #34495e; }
        .main-content { margin-left: 250px; padding: 20px; }
        .header { background-color: #fff; padding: 15px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .btn { display: inline-block; padding: 8px 15px; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-danger { background-color: #e74c3c; }
        .btn-success { background-color: #2ecc71; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .card { background: #fff; padding: 20px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 style="text-align: center; margin-bottom: 20px;">Panel Admin</h3>
        <a href="?c=Admin&a=index">Dashboard</a>
        <a href="?c=Admin&a=productos">Productos</a>
        <a href="?c=Admin&a=pedidos">Pedidos</a>
        <a href="?c=Home&a=index">Volver a Tienda</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Administración</h2>
        </div>
        
        <?php echo $content; ?>
        
    </div>

</body>
</html>
