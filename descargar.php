<?php
// Configuración de la conexión a la base de datos
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

// Verificar si el parámetro book_id está presente
if (isset($_POST['book_id']) && !empty($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);

    // Registrar la fecha de descarga
    $sql_insert = "INSERT INTO descarga (ID_Libro, Fecha_descarga) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        // Definir el camino del archivo PDF basado en el ID del libro
        $file_path = "";
        switch ($book_id) {
            case 201:
                $file_path = "ciencia ficcion_pdf/Frankenstein o el moderno Prometeo-libro.pdf";
                break;
            case 202:
                $file_path = "ciencia ficcion_pdf/Igualdad autor Edward Bellamy.pdf";
                break;
            case 203:
                $file_path = "libros de terror pdf/la-casa-en-el-confin-de-la-tierra-william-hope-hodgson.pdf";
                break;
            case 204:
                $file_path = "libros de terror pdf/LA OSCURIDAD QUE SE CIERNE - FREE VERSION.pdf";
                break;
            case 205:
                $file_path = "libros educativos pdf/Matemáticas I Álgebra y Geometría.pdf";
                break;
            case 206:
                $file_path = "libros educativos pdf/morris-introduccion-a-la-psicologia.pdf";
                break;
            case 207:
                $file_path = "libros de romance pdf/El doncel de don Enrique el doliente autor Mariano José de Larra.pdf";
                break;
            case 208:
                $file_path = "libros de romance pdf/La edad de la inocencia autor Edith Wharton.pdf";
                break;
            case 209:
                $file_path = "libros de aventura pdf/A la Conquista de un Imperio autor Emilio Salgari.pdf";
                break;
            case 210:
                $file_path = "libros de aventura pdf/El Capitán Tormenta I autor Emilio Salgari.pdf";
                break;
            case 211:
                $file_path = "libros de suspenso pdf/El hombre invisible autor HG Wells.pdf";
                break;
            case 212:
                $file_path = "libros de suspenso pdf/La isla del doctor Moreau autor H. G. Wells.pdf";
                break;
            default:
                echo "ID de libro no reconocido.";
                exit();
        }

        // Verifica que el archivo exista
        if (file_exists($file_path)) {
            // Redirigir al archivo PDF para su descarga
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Limpia el buffer del sistema
            readfile($file_path);
            exit;
        } else {
            echo "Archivo no encontrado.";
        }
    } else {
        echo "Error al registrar la descarga: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID de libro no proporcionado.";
}

$conn->close();
?>
