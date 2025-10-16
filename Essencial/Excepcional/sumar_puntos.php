<?php
include 'conexion.php'; 


$nombre = $_POST['nombre'] ?? '';
$puntos = $_POST['puntos'] ?? 0;


if (empty($nombre)) {
    echo json_encode(['error' => 'Falta el nombre del alumno']);
    exit;
}


$sql = "UPDATE usuarios SET puntos = puntos + ? WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $puntos, $nombre);
$stmt->execute();


$sql = "SELECT puntos FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$puntosTotales = $row['puntos'];


$sql = "INSERT INTO puntos (nombre_alumno, puntos, ultima_actualizacion)
        VALUES (?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
        puntos = VALUES(puntos),
        ultima_actualizacion = NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nombre, $puntosTotales);
$stmt->execute();


echo json_encode(['ok' => true, 'puntos' => $puntosTotales]);

$conn->close();
?>

