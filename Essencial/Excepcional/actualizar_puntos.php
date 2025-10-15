<?php
$conexion = new mysqli("localhost", "root", "", "jardin_db");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario_id = $_POST['usuario_id'];
$puntos_nuevos = $_POST['puntos'];

$sql = "INSERT INTO puntos (usuario_id, puntos)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE puntos = puntos + VALUES(puntos)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $puntos_nuevos);
$stmt->execute();

echo "Puntos actualizados correctamente";

$stmt->close();
$conexion->close();
?>