<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

try {
    // Consulta preparada para obtener los pagos
    $query = "SELECT PagoID, UsuarioID, Monto, Pagado FROM Pagos";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result) {
            // Obtener los pagos en un array asociativo
            $pagos = $result->fetch_all(MYSQLI_ASSOC);

            // JSON encode para enviar al frontend
            echo json_encode($pagos);
        } else {
            throw new Exception("Error al obtener los pagos");
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
