<?php
$servername = "localhost";
$username = "root";
$password = ""; // tu contraseña si usás XAMPP puede quedar vacía
$dbname = "jardin_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jardin_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['ok' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
}
?>

