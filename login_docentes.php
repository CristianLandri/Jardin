<?php
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'jardin';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['ok' => false, 'error' => $conn->connect_error]);
    exit;
}

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (!$usuario || !$contrasena) {
    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Buscar docente
$stmt = $conn->prepare("SELECT id, contrasena FROM docentes WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo json_encode(['ok' => false]);
    exit;
}

$stmt->bind_result($id_docente, $hash);
$stmt->fetch();

if (password_verify($contrasena, $hash)) {
    // Registrar hora de entrada
    $hora_entrada = date('Y-m-d H:i:s');
    $stmt2 = $conn->prepare("INSERT INTO registros_docentes (docente_id, hora_entrada) VALUES (?, ?)");
    $stmt2->bind_param("is", $id_docente, $hora_entrada);
    $stmt2->execute();

    $registro_id = $stmt2->insert_id;

    echo json_encode(['ok' => true, 'registro_id' => $registro_id]);
} else {
    echo json_encode(['ok' => false]);
}

$stmt->close();
$conn->close();
?>
