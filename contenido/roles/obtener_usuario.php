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

    // Verificar si se proporciona un ID en la solicitud GET
    if (isset($_GET['id'])) {
        // Obtener el ID del usuario desde la solicitud
        $idUsuario = $_GET['id'];

        // Consultar datos específicos del usuario por su ID
        $query = "SELECT * FROM usuarios WHERE UsuarioID = $idUsuario";

        // Ejecutar la consulta
        $result = $conexion->query($query);

        // Verificar errores en la consulta
        if (!$result) {
            throw new Exception("Error en la consulta: " . $conexion->error);
        }

        // Obtener datos del usuario específico
        $usuario = $result->fetch_assoc();

        // Enviar datos en formato JSON
        echo json_encode($usuario);
    } else {
        // Si no se proporciona un ID, devolver un error
        throw new Exception("No se proporcionó un ID de usuario.");
    }
} catch (Exception $e) {
    // Capturar y manejar cualquier excepción
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    // Cerrar la conexión de todas formas
    if (isset($conexion)) {
        $conexion->close();
    }
}
