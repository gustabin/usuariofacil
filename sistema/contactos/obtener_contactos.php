<?php
// Incluir el archivo de configuración
require '../../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Array para la respuesta JSON
$response = array();

try {
    $query = "SELECT * FROM contactos";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result) {
            // Obtener los contactos en un array asociativo
            $contactos = $result->fetch_all(MYSQLI_ASSOC);

            // Aplicar htmlspecialchars a cada valor en el array
            $contactos = array_map(function ($contacto) {
                return array_map('htmlspecialchars', $contacto);
            }, $contactos);

            // JSON encode para enviar al frontend
            echo json_encode($contactos);
        } else {
            throw new Exception("Error al obtener los contactos");
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        throw new Exception("Error al preparar la consulta");
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Cierra la conexión
$conexion->close();

// Devolver la respuesta en formato JSON
// header('Content-Type: application/json');
// echo json_encode($response);
