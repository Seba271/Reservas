<?php
// app/models/Usuario.php

require_once 'config/database.php'; // Incluye el archivo de configuración de la base de datos

class Usuario {
    private $conn;
    private $table_name = "usuarios"; // Nombre de la tabla en la base de datos

    // Propiedades del usuario
    public $id;
    public $nombre;
    public $email;
    public $contraseña;
    public $rol;
    public $fecha_registro;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, email=:email, contraseña=:contraseña, rol=:rol";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contraseña', $this->contraseña);
        $stmt->bindParam(':rol', $this->rol);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Leer un usuario específico por su email
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        
        // Enlazar el email del usuario
        $stmt->bindParam(1, $this->email);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        return $stmt;
    }

    // Actualizar los detalles de un usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, contraseña=:contraseña, rol=:rol WHERE id=:id";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':contraseña', $this->contraseña);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':id', $this->id);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar un usuario por su ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        
        // Enlazar el ID del usuario
        $stmt->bindParam(1, $this->id);
        
        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
