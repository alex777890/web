<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    $sql = "UPDATE usuario SET Nombre='$nombre', Apellido='$apellido', Correo_electronico='$correo' WHERE ID_Usuario='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado con éxito.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
