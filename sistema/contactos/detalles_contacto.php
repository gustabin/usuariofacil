<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conexion, 'utf8');
try {
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
