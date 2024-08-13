<?php
function registrarActividad($conn, $userId, $actividad) {
    $sql = "INSERT INTO Log_Actividad (ID_Usuario, Actividad, Fecha_hora) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $actividad);

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }
}
?>