<?php
session_start();

// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar si la sesión está iniciada y si la clave 'usuarioID' está definida
if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['usuarioID'])) {
    $response['status'] = 'error';
    $response['message'] = 'La sesión no está iniciada o no se ha proporcionado el usuarioID';
    echo json_encode($response);
    exit;
}

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuarioID'])) {
        throw new Exception("Usuario no autenticado.");
    }

    $usuarioID = filter_var($_SESSION['usuarioID'], FILTER_VALIDATE_INT);

    if ($usuarioID === false || $usuarioID <= 0) {
        throw new Exception("ID de usuario no válido.");
    }

    $query = "SELECT * FROM pedidos WHERE UsuarioID = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    // Vincular el parámetro
    $stmt->bind_param("i", $usuarioID);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si hay errores en la ejecución
    if ($stmt->errno) {
        throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si el resultado está vacío
    if ($result->num_rows === 0) {
        echo json_encode(array('message' => 'No se encontraron pedidos para el usuario.'));
    } else {
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($pedidos);
    }

    // Cerrar el statement
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

// Cierra la conexión
$conexion->close();
