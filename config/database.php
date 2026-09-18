<?php
// config/database.php

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // En Vercel, estas variables se configurarán en las "Environment Variables" del proyecto
        // Si no existen (ej. entorno local), usamos los valores por defecto de XAMPP
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->db_name = getenv('DB_NAME') ?: "tienda_calzado";
        $this->username = getenv('DB_USER') ?: "root";
        $this->password = getenv('DB_PASS') ?: "";
    }

    public function getConnection() {
        $this->conn = null;

        try {
            // Conexión PDO con opciones para máxima seguridad y manejo de errores
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
            // En producción, es mejor loguear el error y mostrar un mensaje genérico.
        }

        return $this->conn;
    }
}
?>
