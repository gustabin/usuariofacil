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

// Array para la respuesta JSON
$response = array('success' => false);

try {
    // Validar la presencia y el tipo del parámetro contactoID
    if (!isset($_GET['contactoID']) || !is_numeric($_GET['contactoID'])) {
        throw new Exception("Parámetro 'contactoID' no válido");
    }

    // Sanitizar el parámetro contactoID
    $contactoID = (int)$_GET['contactoID'];

    // Obtener el token CSRF enviado
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

    // Verificar si el token CSRF enviado es válido
    if (!empty($_SESSION['csrf_token']) && !empty($token) && hash_equals($_SESSION['csrf_token'], $token)) {
        // Consulta SQL para eliminar el contacto
        $query = "DELETE FROM contactos WHERE id = ?";

        // Preparar la consulta
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            // Vincular el parámetro
            $stmt->bind_param("i", $contactoID);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si la eliminación fue exitosa
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            throw new Exception("Error al preparar la consulta");
        }

        unset($_SESSION['csrf_token']);
    } else {
        throw new Exception("Token CSRF no válido");
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Cierra la conexión
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
