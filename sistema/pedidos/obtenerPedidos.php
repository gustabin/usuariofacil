<?php
session_start();
// Incluir el archivo de configuración
require '../../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

try {
    $usuarioID = $_SESSION['usuarioID'];

    $query = "SELECT * FROM Pedidos WHERE UsuarioID = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular el parámetro
        $stmt->bind_param("i", $usuarioID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result) {
            $pedidos = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($pedidos);
        } else {
            throw new Exception("Error al obtener los pedidos");
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
