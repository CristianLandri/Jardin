<?php
$servername = "db.tecnica4berazategui.edu.ar";
$username = "pprof_ji_dbu";
$password = 'ZJi$ybG64bd4{mN)}B+s7YfZ^WUH)i6_G}CaSY_**RYi8|Kd';
$database = "pprof_juegosinfantilesdb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
   
    error_log('DB connection error: ' . $conn->connect_error);
    die(json_encode(['error' => 'Error de conexión a la base de datos.']));
}


if (! $conn->set_charset('utf8mb4')) {
    error_log('Error cargando el conjunto de caracteres utf8mb4: ' . $conn->error);
}


$conexion = $conn;
?>
