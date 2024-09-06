<?php
// app/models/Reserva.php

require_once 'config/database.php'; // Incluye el archivo de configuración de la base de datos

class Reserva {
    private $conn;
    private $table_name = "reservas"; // Nombre de la tabla en la base de datos

    // Propiedades de la reserva
    public $id;
    public $id_usuario;
    public $id_sala;
    public $fecha_reserva;
    public $hora_inicio;
    public $hora_fin;
    public $estado;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva reserva
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET id_usuario=:id_usuario, id_sala=:id_sala, fecha_reserva=:fecha_reserva, hora_inicio=:hora_inicio, hora_fin=:hora_fin, estado=:estado";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_sala', $this->id_sala);
        $stmt->bindParam(':fecha_reserva', $this->fecha_reserva);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_fin', $this->hora_fin);
        $stmt->bindParam(':estado', $this->estado);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Leer todas las reservas
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // Leer una reserva específica por su ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar el ID de la reserva
        $stmt->bindParam(1, $this->id);

        // Ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // Actualizar los detalles de una reserva
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET id_usuario=:id_usuario, id_sala=:id_sala, fecha_reserva=:fecha_reserva, hora_inicio=:hora_inicio, hora_fin=:hora_fin, estado=:estado WHERE id=:id";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar los valores de las propiedades del objeto
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_sala', $this->id_sala);
        $stmt->bindParam(':fecha_reserva', $this->fecha_reserva);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_fin', $this->hora_fin);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id', $this->id);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar una reserva por su ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar el ID de la reserva
        $stmt->bindParam(1, $this->id);

        // Ejecutar la consulta y devolver verdadero si se ejecutó con éxito
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
