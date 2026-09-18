<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNEAKERX - Tienda Deportiva</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #111;
            --primary-light: #333;
            --accent: #ff4757;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-dark: #2f3542;
            --text-gray: #747d8c;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
        }

        /* Navbar */
        .navbar {
            background: var(--card-bg);
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -1px;
        }
        .logo span {
            color: var(--accent);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary-light);
            font-weight: 600;
            margin-left: 30px;
            font-size: 14px;
            text-transform: uppercase;
            transition: var(--transition);
        }
        
        .nav-links a:hover {
            color: var(--accent);
        }

        /* Cart Icon */
        .cart-icon {
            position: relative;
            cursor: pointer;
        }
        .cart-count {
            position: absolute;
            top: -10px;
            right: -15px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Footer */
        .footer {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 40px 20px;
            margin-top: 60px;
        }

        /* Utilidades */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="?c=Home&a=index" class="logo">SNEAKER<span>X</span></a>
        
        <div class="nav-links">
            <a href="?c=Home&a=index">Catálogo</a>
            <a href="#">Hombre</a>
            <a href="#">Mujer</a>
            <a href="?c=Admin&a=index" style="color: var(--text-gray);"><small>Admin</small></a>
            
            <a href="?c=Cart&a=index" class="cart-icon">
                🛒 Mi Carrito <span class="cart-count">
                    <?php 
                    $cart_count = 0;
                    if(isset($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $item) {
                            $cart_count += $item['cantidad'];
                        }
                    }
                    echo $cart_count; 
                    ?>
                </span>
            </a>
        </div>
    </nav>

    <div class="container">
        <?php echo $content; ?>
    </div>

    <footer class="footer">
        <h3>SNEAKERX</h3>
        <p style="color: #999; margin-top: 10px;">La mejor tienda de calzado deportivo.</p>
        <p style="color: #666; margin-top: 20px; font-size: 12px;">&copy; <?php echo date('Y'); ?> SneakerX. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
