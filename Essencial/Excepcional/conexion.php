<?php
$servername = "localhost";
$username = "root";
$password = ""; // dejar vacío si usás XAMPP
$database = "jardin_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}
?>
