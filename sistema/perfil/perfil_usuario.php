<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variable de entrada
session_start();
$usuarioID =  $_SESSION['usuarioID'];

// var_dump($usuarioID);
// die();

$response = array();
// Consulta preparada para obtener el perfil de un usuario
$query = "SELECT * FROM Perfiles WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $usuarioID);
$stmt->execute();
$result = $stmt->get_result();

// Obtener los datos del perfil
if ($result->num_rows > 0) {
    $perfil = $result->fetch_assoc();

    // Puedes acceder a los datos del perfil
    $nombre = $perfil['Nombre'];
    $apellido = $perfil['Apellido'];
    $avatarURL = $perfil['AvatarURL'];

    // echo "Nombre: $nombre, Apellido: $apellido, AvatarURL: $avatarURL";
    // Imprime los datos en formato JSON
    $response['status'] = 'exito';
    $response['nombre'] = $nombre;
    $response['apellido'] = $apellido;
    $response['avatarURL'] = $avatarURL;
} else {
    //echo "No se encontraron resultados para el usuario con ID $usuarioID";
    $response['status'] = 'error';
    $response['message'] = 'No se encontraron resultados para el usuario con ID ' . $usuarioID;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);
