<?php
header('Content-Type: application/json; charset=utf-8');

$conexion = new mysqli("localhost", "root", "", "jardin_db");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

$sql = "SELECT u.id, u.nombre, IFNULL(p.puntos, 0) AS puntos, 
        IFNULL(p.ultima_actualizacion, '-') AS ultima_actualizacion
        FROM usuarios u
        LEFT JOIN puntos p ON u.id = p.usuario_id
        ORDER BY p.puntos DESC";

$resultado = $conexion->query($sql);

$datos = array();

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
$conexion->close();
?>
