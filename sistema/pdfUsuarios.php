<?php
require_once('vendor/autoload.php'); // Ajusta la ruta según tu estructura de directorios

use TCPDF as TCPDF;

session_start();
if ($_SESSION['rol'] == 1) {
    // Crear una nueva instancia de TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Establecer el título del documento y otras propiedades
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tu Empresa');
    $pdf->SetTitle('Lista de Usuarios');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 30);

    // Agregar página
    $pdf->AddPage();

    // Agregar encabezado con el logo de la empresa
    $pdf->Image('../imagen/logo.png', 170, 12, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Establecer el contenido del cuerpo (aquí deberías listar los registros de usuarios)
    $html = '<h1>Lista de Usuarios</h1>';
    $html .= '<table border="1"><tr><th>ID</th><th>Email</th><th>Verificado</th></tr>';

    // Obtener usuarios para el PDF
    $usuarios = obtenerUsuarios();
    foreach ($usuarios as $usuario) {
        // $html .= '<tr><td>' . $usuario['id'] . '</td><td>' . $usuario['email'] . '</td><td>' . $usuario['verificado'] . '</td></tr>';
        $html .= '<tr><td>' . $usuario['UsuarioID'] . '</td><td>' . $usuario['Email'] . '</td><td>' . $usuario['Verificado'] . '</td></tr>';
    }
    $html .= '</table>';

    // Agregar espacio vertical entre el logo y la tabla solo si hay datos
    if (!empty($usuarios)) {
        $html = '<br>' . $html;
    }

    $pdf->writeHTML($html, true, false, true, false, '');

    // Salida del PDF (descargar o mostrar)
    $pdf->Output('lista_usuarios.pdf', 'I');
} else {
    header("Location: ../login/index.html");
    exit();
}


// Función ficticia para obtener usuarios (debes implementarla según tu lógica)
function obtenerUsuarios()
{
    // Aquí deberías recuperar tus registros de usuarios desde tu base de datos u otra fuente de datos
    // y devolverlos como un array
    // return array(
    //     array('id' => 1, 'email' => 'usuario1@example.com', 'verificado' => 1),
    //     array('id' => 2, 'email' => 'usuario2@example.com', 'verificado' => 0),
    //     // ... otros usuarios
    // );
    // Incluir el archivo de configuración
    require '../tools/config.php';

    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($conexion, 'utf8');

    // Crea un array para almacenar los usuarios
    $usuarios = array();

    // Consulta para obtener los usuarios
    $sql = 'SELECT * FROM Usuarios'; // Ajusta la tabla según tu esquema de base de datos
    $stmt = $conexion->prepare($sql);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene los resultados
    $result = $stmt->get_result();

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Itera sobre los resultados y agrega cada usuario al array
        while ($fila = $result->fetch_assoc()) {
            $usuarios[] = $fila;
        }
    }

    $stmt->close(); // Cierra la declaración preparada
    $conexion->close();

    return $usuarios;
}
