<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variable de entrada
$usuarioID = 1;

// Obtener la URL del avatar actual en la base de datos
$selectQuery = "SELECT AvatarURL FROM Perfiles WHERE UsuarioID = ?";
$selectStmt = $conexion->prepare($selectQuery);
$selectStmt->bind_param('i', $usuarioID);
$selectStmt->execute();
$selectStmt->store_result();
$selectStmt->bind_result($avatarURL);
$selectStmt->fetch();

// Eliminar el archivo de la ubicación de almacenamiento
// echo $avatarURL;
// die();
unlink($avatarURL);

// Actualizar la URL del avatar en la base de datos
$updateQuery = "UPDATE Perfiles SET AvatarURL = NULL WHERE UsuarioID = ?";
$updateStmt = $conexion->prepare($updateQuery);
$updateStmt->bind_param('i', $usuarioID);
$updateStmt->execute();

// Cerrar la conexión
$selectStmt->close();
$updateStmt->close();
$conexion->close();
