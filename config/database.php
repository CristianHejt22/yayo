<?php
// config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "tienda_calzado";
    private $username = "root"; // Ajustar según el entorno local
    private $password = ""; // Ajustar según el entorno local
    public $conn;

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
