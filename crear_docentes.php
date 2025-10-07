<?php
// Datos del docente
$usuario = "docente1"; // el nombre de usuario que quieras
$contrasena = password_hash("Jardin_2025", PASSWORD_DEFAULT); // contraseña que quieras

echo "Usuario: " . $usuario . "<br>";
echo "Contraseña encriptada: " . $contrasena;
?>
