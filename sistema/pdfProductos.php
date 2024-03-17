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
    $pdf->SetTitle('Lista de Productos');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 30);

    // Agregar página
    $pdf->AddPage();

    // Agregar encabezado con el logo de la empresa
    $pdf->Image('../imagen/logo.png', 170, 12, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Establecer el contenido del cuerpo (aquí deberías listar los registros de productos)
    $html = '<h1>Lista de Productos</h1>';
    $html .= '<table border="1"><tr><th width="40">ID</th><th width="90">Código</th><th>Imagen</th><th width="180">Nombre</th><th width="80">Precio</th><th width="60">Stock</th></tr>';

    // Obtener productos para el PDF
    $productos = obtenerproductos();
    foreach ($productos as $producto) {
        $html .= '<tr><td>' . $producto['ProductoID'] . '</td><td>' . $producto['Codigo'] . '</td><td>' . mostrarImagen($producto['ImagenURL']) . '</td><td>' . $producto['Nombre'] . '</td><td>' . $producto['Precio'] . '</td><td>' . $producto['Stock'] . '</td></tr>';
    }
    $html .= '</table>';

    // Agregar espacio vertical entre el logo y la tabla solo si hay datos
    if (!empty($productos)) {
        $html = '<br>' . $html;
    }

    $pdf->writeHTML($html, true, false, true, false, '');

    // Salida del PDF (descargar o mostrar)
    $pdf->Output('lista_productos.pdf', 'I');
} else {
    header("Location: ../login/index.html");
    exit();
}

// Función ficticia para obtener productos (debes implementarla según tu lógica)
function obtenerproductos()
{
    // Incluir el archivo de configuración
    require '../tools/config.php';

    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($conexion, 'utf8');

    // Crea un array para almacenar los productos
    $productos = array();

    // Consulta para obtener los productos
    $sql = 'SELECT * FROM productos'; // Ajusta la tabla según tu esquema de base de datos
    $stmt = $conexion->prepare($sql);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene los resultados
    $result = $stmt->get_result();

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Itera sobre los resultados y agrega cada producto al array
        while ($fila = $result->fetch_assoc()) {
            $productos[] = $fila;
        }
    }

    $stmt->close(); // Cierra la declaración preparada
    $conexion->close();

    return $productos;
}

// Función para mostrar la imagen en HTML
function mostrarImagen($imagenNombre)
{
    // Ruta a la carpeta de imágenes
    $rutaImagenes = '../';

    // Puedes ajustar el tamaño según tus necesidades
    return '<img src="' . $rutaImagenes . $imagenNombre . '" width="90" height="90">';
}
