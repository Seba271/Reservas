<?php
session_start(); // Iniciar sesión

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservas_salasdeestudio"; // Cambia esto al nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'];
$contraseña = $_POST['contraseña'];

// Buscar el usuario en la base de datos
$sql = "SELECT * FROM Usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($contraseña == $row['contraseña']) { // Comparar directamente
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['nombre'];
        $_SESSION['user_role'] = $row['rol'];
        // Redireccionar al área segura o mostrar mensaje
        echo "Contraseña correcta.";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "No existe un usuario con ese email.";
}

$conn->close();
?>
