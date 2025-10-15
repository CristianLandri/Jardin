<?php
include 'conexion.php';
$nombre = $_POST['nombre'] ?? '';

$sql = "SELECT puntos FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  echo json_encode(['puntos' => $row['puntos']]);
} else {
  echo json_encode(['error' => 'Usuario no encontrado']);
}
$conn->close();
?>
