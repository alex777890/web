<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Contraseña por defecto en XAMPP
$dbname = "librarydb"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar y ejecutar la consulta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST['comentario'];
    
    // Usa una consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO comentarios (comentario) VALUES (?)");
    $stmt->bind_param("s", $comentario);
    
    if ($stmt->execute()) {
        echo "Comentario guardado exitosamente.";
    } else {
        echo "Error al guardar el comentario: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
