<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variable de entrada
$usuarioID = 14;

// Consulta preparada para marcar un usuario como verificado
$query = "UPDATE Usuarios SET Verificado = true WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $usuarioID);
$stmt->execute();

// Cerrar la conexión
$stmt->close();
$conexion->close();
