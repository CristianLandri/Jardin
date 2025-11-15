<?php
// actualizar_puntos.php
// Actualiza puntos para un usuario por su id
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexion.php';

// $conn provisto por conexion.php
if (!isset($conn) || !$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'No hay conexión a la base de datos.']);
    exit;
}

$usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : null;
$puntos_nuevos = isset($_POST['puntos']) ? intval($_POST['puntos']) : null;

if ($usuario_id === null || $puntos_nuevos === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Parámetros faltantes: usuario_id y puntos son requeridos.']);
    exit;
}

// Ajusta tabla/columnas si tu esquema es distinto
$sql = "UPDATE usuarios SET puntos = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('ii', $puntos_nuevos, $usuario_id);
    if ($stmt->execute()) {
        if ($conn->affected_rows > 0) {
            echo json_encode(['ok' => true, 'message' => 'Puntos actualizados correctamente.']);
        } else {
            echo json_encode(['ok' => false, 'message' => 'No se actualizó (id no encontrado o mismo valor).']);
        }
    } else {
        http_response_code(500);
        error_log('actualizar_puntos execute error: ' . $stmt->error);
        echo json_encode(['error' => 'Error al ejecutar la actualización.']);
    }
    $stmt->close();
} else {
    http_response_code(500);
    error_log('actualizar_puntos prepare error: ' . $conn->error);
    echo json_encode(['error' => 'Error al preparar la consulta.']);
}

$conn->close();
?>