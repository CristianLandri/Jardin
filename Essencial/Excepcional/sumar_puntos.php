<?php
include 'conexion.php'; // ✅ Deja esto igual, así se conecta a la base

// ✅ Recibir los datos que vienen del juego
$nombre = $_POST['nombre'] ?? '';
$puntos = $_POST['puntos'] ?? 0;

// ✅ Si no hay nombre, no seguimos
if (empty($nombre)) {
    echo json_encode(['error' => 'Falta el nombre del alumno']);
    exit;
}

// ✅ 1. SUMA los puntos en la tabla usuarios
$sql = "UPDATE usuarios SET puntos = puntos + ? WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $puntos, $nombre);
$stmt->execute();

// ✅ 2. Obtiene los puntos totales del usuario
$sql = "SELECT puntos FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$puntosTotales = $row['puntos'];

// ✅ 3. Inserta o actualiza la tabla 'puntos'
$sql = "INSERT INTO puntos (nombre_alumno, puntos, ultima_actualizacion)
        VALUES (?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
        puntos = VALUES(puntos),
        ultima_actualizacion = NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nombre, $puntosTotales);
$stmt->execute();

// ✅ 4. Devuelve los puntos actualizados al navegador
echo json_encode(['ok' => true, 'puntos' => $puntosTotales]);

$conn->close();
?>
