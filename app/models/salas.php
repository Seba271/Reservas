<?php
// app/models/Sala.php

require_once 'config/database.php'; // Incluye el archivo de configuración de la base de datos

class Sala {
    private $conn;
    private $table_name = "salas"; // Nombre de la tabla en la base de datos

    // Propiedades de la sala
    public $id;
    public $nombre;
    public $ubicacion;
    public $estado;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva sala
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, ubicacion=:ubicacion, estado=:estado";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':estado', $this->estado);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Leer todas las salas
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // Leer una sala específica por su ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar el ID de la sala
        $stmt->bindParam(1, $this->id);

        // Ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // Actualizar los detalles de una sala
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, ubicacion=:ubicacion, estado=:estado WHERE id=:id";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id', $this->id);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar una sala por su ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar el ID de la sala
        $stmt->bindParam(1, $this->id);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
