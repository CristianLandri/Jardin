<?php
include 'conexion.php';

$nombre = $_POST['nombre'] ?? '';
$puntos = $_POST['puntos'] ?? 0;

if (empty($nombre)) {
  echo json_encode(['error' => 'Nombre vacío']);
  exit;
}

// Actualizar puntos
$sql = "UPDATE usuarios SET puntos = puntos + ? WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $puntos, $nombre);
$stmt->execute();

// Obtener puntos actualizados
$sql = "SELECT puntos FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['nombre' => $nombre, 'puntos' => $row['puntos']]);
$conn->close();
?>
