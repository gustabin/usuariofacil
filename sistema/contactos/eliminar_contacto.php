<?php
session_start();
// Incluir el archivo de configuración
require '../../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

try {
    // Obtener el token CSRF enviado
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

    // Verificar si el token CSRF enviado es válido
    if (!empty($_SESSION['csrf_token']) && !empty($token) && hash_equals($_SESSION['csrf_token'], $token)) {
        // Obtener el ID del contacto desde la consulta GET
        $contactoID = $_GET['contactoID'];

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
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
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
    echo json_encode(array('error' => $e->getMessage()));
}

// Cierra la conexión
$conexion->close();
