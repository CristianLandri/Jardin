<?php
// obtener_puntos.php
// Devuelve puntos de un usuario o ranking completo
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexion.php';

if (!isset($conn) || !$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'No hay conexión a la base de datos.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);
    if ($nombre === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Nombre vacío']);
        exit;
    }

    // Buscar usuario de forma segura
    $sql = "SELECT nombre, puntos FROM usuarios WHERE nombre = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            echo json_encode($row);
        } else {
            // Crear usuario si no existe
            $ins = $conn->prepare("INSERT INTO usuarios (nombre, puntos) VALUES (?, 0)");
            if ($ins) {
                $ins->bind_param('s', $nombre);
                $ins->execute();
                echo json_encode(['nombre' => $nombre, 'puntos' => 0]);
                $ins->close();
            } else {
                error_log('obtener_puntos insert error: ' . $conn->error);
                http_response_code(500);
                echo json_encode(['error' => 'Error interno al crear usuario']);
            }
        }
        $stmt->close();
    } else {
        error_log('obtener_puntos prepare error: ' . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Error interno']);
    }

} else {
    // Listado/ranking
    $sql = "SELECT nombre, puntos, NOW() AS ultima_actualizacion FROM usuarios ORDER BY puntos DESC";
    $resultado = $conn->query($sql);
    $datos = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
    }
    echo json_encode($datos);
}

$conn->close();
?>
