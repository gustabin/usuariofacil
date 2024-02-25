<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

try {
    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar errores de conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT UsuarioID, Email, rol FROM usuarios";

    // Ejecutar la consulta
    $result = $conexion->query($query);

    // Verificar errores en la consulta
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $usuarios = [];

    // Obtener datos
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    // Enviar datos en formato JSON para DataTable
    echo json_encode(['data' => $usuarios]);
} catch (Exception $e) {
    // Capturar y manejar cualquier excepción
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    // Cerrar la conexión de todas formas
    if (isset($conexion)) {
        $conexion->close();
    }
}
