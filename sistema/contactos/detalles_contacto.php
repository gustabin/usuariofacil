<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
session_start();
// Verificar si la sesión está iniciada y si la clave 'usuarioID' está definida
if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['usuarioID'])) {
    $response['status'] = 'error';
    $response['message'] = 'La sesión no está iniciada o no se ha proporcionado el usuarioID';
    echo json_encode($response);
    exit;
}

mysqli_set_charset($conexion, 'utf8');
try {
    // Validar la presencia y el tipo del parámetro contactoID
    if (!isset($_GET['contactoID']) || !is_numeric($_GET['contactoID'])) {
        throw new Exception("Parámetro 'contactoID' no válido");
    }
    // Obtener el ID del contacto desde la consulta GET
    $contactoID = $_GET['contactoID'];

    // Consulta SQL para obtener detalles del contacto con información del producto
    $query = "SELECT * FROM contactos WHERE id = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular el parámetro
        $stmt->bind_param("i", $contactoID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result) {
            $detalles = $result->fetch_assoc();
            echo json_encode($detalles);
        } else {
            throw new Exception("Error al obtener los detalles del contacto");
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        throw new Exception("Error al preparar la consulta");
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

// Cierra la conexión
$conexion->close();
