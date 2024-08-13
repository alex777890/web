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

// Consultar los comentarios
$sql = "SELECT comentario, fecha FROM comentarios ORDER BY fecha DESC";
$result = $conn->query($sql);

// Mostrar los comentarios
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
        echo "<p><small>Fecha: " . $row['fecha'] . "</small></p>";
        echo "</div><hr>";
    }
} else {
    echo "No hay comentarios aún.";
}

$conn->close();
?>