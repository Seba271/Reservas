<?php

class Database {
    private $host = "localhost"; // Servidor de la base de datos
    private $db_name = "reservas_salasdeestudio"; // Nombre de tu base de datos
    private $username = "root"; // Nombre de usuario (en XAMPP es root por defecto)
    private $password = ""; // Contraseña (en XAMPP normalmente no hay contraseña por defecto)
    public $conn;

    // Método para establecer la conexión
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Establecer el modo de error de PDO en excepción
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
