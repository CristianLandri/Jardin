<?php
// salir_docentes.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexion.php';

if (!isset($conn) || !$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'No hay conexión a la base de datos.']);
    exit;
}

$registro_id = isset($_POST['registro_id']) ? intval($_POST['registro_id']) : 0;
if ($registro_id > 0) {
  $hora_salida = date('Y-m-d H:i:s');
  if ($stmt = $conn->prepare("UPDATE registros_docentes SET hora_salida = ? WHERE id = ?")) {
      $stmt->bind_param("si", $hora_salida, $registro_id);
      if ($stmt->execute()) {
          echo json_encode(['ok' => true]);
      } else {
          error_log('salir_docentes execute error: ' . $stmt->error);
          http_response_code(500);
          echo json_encode(['error' => 'Error al actualizar registro']);
      }
      $stmt->close();
  } else {
      error_log('salir_docentes prepare error: ' . $conn->error);
      http_response_code(500);
      echo json_encode(['error' => 'Error interno']);
  }
} else {
  http_response_code(400);
  echo json_encode(['error' => 'Falta registro_id o valor inválido']);
}

$conn->close();
?>
