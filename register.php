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

require 'registrar_actividad.php';  // Incluir el archivo con la función de registro de actividad

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Sanitizar entrada
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $apellido = mysqli_real_escape_string($conn, $apellido);
    $correo = mysqli_real_escape_string($conn, $correo);
    $contrasena = mysqli_real_escape_string($conn, $contrasena);

    // Hash de la contraseña para mayor seguridad
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Consulta para verificar si el correo ya está registrado
    $check_sql = "SELECT ID_Usuario FROM usuario WHERE Correo_electronico='$correo'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Si el correo ya está registrado, mostrar un mensaje y detener el script
        echo "El correo electrónico ya está registrado. <a href='login.html'>Iniciar sesión</a>";
    } else {
        // Consulta para insertar un nuevo usuario en la tabla 'usuario'
        $sql = "INSERT INTO usuario (Nombre, Apellido, Correo_electronico, Contraseña, Fecha_registro) 
                VALUES ('$nombre', '$apellido', '$correo', '$hashed_password', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Obtener el ID del nuevo usuario
            $user_id = $conn->insert_id;

            // Registrar la actividad de registro
            registrarActividad($conn, $user_id, "Registro de nuevo usuario");
            registrarActividad($conn, $user_id, "Inicio de secion");

            // Redirigir a la página de inicio de sesión
            header("Location: login.html");
            exit(); // Asegúrate de usar exit después de header para detener la ejecución del script
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>