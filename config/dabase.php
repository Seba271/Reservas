<?php
#conexion con BD
class Database {
    private $host = "localhost"; // Servidor de la base de datos
    private $db_name = "reservas_salasdeestudio"; // Nombre de tu base de datos
    private $username = "root"; // Nombre de usuario (en XAMPP es root por defecto)
    private $password = ""; // Contraseña (en XAMPP normalmente no hay contraseña por defecto)
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

#SALAS
class Sala {
    private $conn;
    private $table_name = "salas";

    public $id;
    public $nombre;
    public $ubicacion;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las salas
    public function obtenerSalas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Cambiar el estado de una sala
    public function cambiarEstado($id, $nuevo_estado) {
        $query = "UPDATE " . $this->table_name . " SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':estado', $nuevo_estado);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Crear nueva sala
    public function crearSala() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, ubicacion, estado) VALUES (:nombre, :ubicacion, :estado)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->ubicacion = htmlspecialchars(strip_tags($this->ubicacion));
        $this->estado = htmlspecialchars(strip_tags($this->estado));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':estado', $this->estado);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

######### Usuarios#####
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $email;
    public $contraseña;
    public $rol;
    public $fecha_registro;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearUsuario() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, contraseña, rol) VALUES (:nombre, :email, :contraseña, :rol)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);
        $this->rol = htmlspecialchars(strip_tags($this->rol));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contraseña', $this->contraseña);
        $stmt->bindParam(':rol', $this->rol);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function obtenerUsuarioPorEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt;
    }
}
####### reservas 
class Reserva {
    private $conn;
    private $table_name = "reservas";

    public $id;
    public $id_usuario;
    public $id_sala;
    public $fecha_reserva;
    public $hora_inicio;
    public $hora_fin;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva reserva
    public function crearReserva() {
        $query = "INSERT INTO " . $this->table_name . " (id_usuario, id_sala, fecha_reserva, hora_inicio, hora_fin, estado) 
                  VALUES (:id_usuario, :id_sala, :fecha_reserva, :hora_inicio, :hora_fin, :estado)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_sala', $this->id_sala);
        $stmt->bindParam(':fecha_reserva', $this->fecha_reserva);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_fin', $this->hora_fin);
        $stmt->bindParam(':estado', $this->estado);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener reservas de un usuario
    public function obtenerReservasPorUsuario($id_usuario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt;
    }

    // Cambiar estado de una reserva (por ejemplo: confirmada, cancelada)
    public function cambiarEstadoReserva($id, $nuevo_estado) {
        $query = "UPDATE " . $this->table_name . " SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':estado', $nuevo_estado);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener todas las reservas de una sala
    public function obtenerReservasPorSala($id_sala) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_sala = :id_sala";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sala', $id_sala);
        $stmt->execute();
        return $stmt;
    }
}