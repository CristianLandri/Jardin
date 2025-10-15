<?php
// crear_docente.php
header('Content-Type: application/json');
ini_set('display_errors', 0); // evita que warnings salgan en HTML y rompan el JSON
require_once 'conexion.php'; // tu conexión mysqli ($conn)

$usuario = 'Docente2';           // CAMBIÁ por el usuario que quieras
$clave_real = 'Jardin_2025';     // la contraseña real que dará el docente

$hash = password_hash($clave_real, PASSWORD_DEFAULT);

// insertar (si ya existe, podés cambiar a UPDATE)
$stmt = $conn->prepare("INSERT INTO docentes (usuario, contrasena) VALUES (?, ?)");
$stmt->bind_param('ss', $usuario, $hash);
if ($stmt->execute()) {
    echo json_encode(['ok' => true, 'msg' => 'Docente creado', 'id' => $stmt->insert_id]);
} else {
    echo json_encode(['ok' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
