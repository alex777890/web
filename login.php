<?php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarydb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Sanitizar entrada
    $correo = mysqli_real_escape_string($conn, $correo);
    $contrasena = mysqli_real_escape_string($conn, $contrasena);

    // Consulta para verificar el usuario
    $sql = "SELECT ID_Usuario, Nombre, Contraseña FROM usuario WHERE Correo_electronico='$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['Contraseña'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['user_id'] = $row['ID_Usuario'];
            $_SESSION['user_name'] = $row['Nombre'];

            // Redirigir a la página de usuario
            header("Location: Pagina de usuario.html");
            exit(); // Asegúrate de usar exit después de header para detener la ejecución del script
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Correo electrónico no registrado.";
    }
}

$conn->close();
?>