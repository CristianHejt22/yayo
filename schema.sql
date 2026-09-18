-- Tienda Virtual de Calzado Deportivo - Base de Datos MySQL

CREATE DATABASE IF NOT EXISTS tienda_calzado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda_calzado;

-- Tabla de Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(50),
    direccion VARCHAR(255),
    localidad VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Productos (Modelos de Calzado)
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    estado_publicacion ENUM('activo', 'pausado', 'oculto') DEFAULT 'activo',
    imagen_principal VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Variantes de Productos (Talles y Colores vitales para calzado)
CREATE TABLE IF NOT EXISTS producto_variantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    talle VARCHAR(10) NOT NULL,
    color VARCHAR(50) NOT NULL,
    stock INT DEFAULT 0,
    sku VARCHAR(100) UNIQUE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Tabla de Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('mercadopago', 'transferencia', 'efectivo') NOT NULL,
    estado_pago ENUM('pendiente', 'pagado', 'rechazado', 'cancelado') DEFAULT 'pendiente',
    estado_envio ENUM('preparacion', 'despachado', 'entregado', 'retira_local') DEFAULT 'preparacion',
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    datos_extra TEXT, -- Puede usarse para guardar ID de transacción de MP o comprobantes
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabla de Ítems de Pedidos
CREATE TABLE IF NOT EXISTS pedido_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    variante_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (variante_id) REFERENCES producto_variantes(id)
);

-- Insertar datos de prueba iniciales
INSERT INTO productos (nombre, marca, descripcion, precio, imagen_principal) VALUES
('Air Max 270', 'Nike', 'Zapatillas de running con gran amortiguación.', 150000.00, 'airmax270.jpg'),
('Ultraboost 22', 'Adidas', 'Máximo confort y retorno de energía.', 180000.00, 'ultraboost.jpg');

INSERT INTO producto_variantes (producto_id, talle, color, stock, sku) VALUES
(1, '40', 'Negro', 15, 'NK-AM270-40N'),
(1, '41', 'Negro', 10, 'NK-AM270-41N'),
(1, '42', 'Blanco', 5, 'NK-AM270-42B'),
(2, '39', 'Azul', 8, 'AD-UB22-39A'),
(2, '40', 'Azul', 12, 'AD-UB22-40A');
