<?php
$nombre_usuario = "Nombre del usuario";
$modulo = "Pagos";
require_once("../tools/header.php");
// Incluir el archivo de configuración
// require '../tools/config.php';

// Conexión a la base de datos
// $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Obtener el ID del usuario logueado
// $usuarioID = $_SESSION['usuarioID'];

// // Obtener productos disponibles desde la tabla Pedidos para el usuario logueado
// $queryProductos = "SELECT * FROM Pedidos WHERE UsuarioID = ?";
// $stmtProductos = $conexion->prepare($queryProductos);

// if (!$stmtProductos) {
//     die('Error en la preparación de la consulta: ' . $conexion->error);
// }

// $stmtProductos->bind_param('i', $usuarioID);
// $stmtProductos->execute();
// $resultProductos = $stmtProductos->get_result();

// // Cerrar la conexión
// $stmtProductos->close();
// $conexion->close();
?>
<style>
    /* Estilos para resaltar los pagos realizados */
    .pago-realizado {
        background-color: #c8e6c9;
        /* Verde claro */
    }

    /* Estilos para resaltar los pagos pendientes */
    .pago-pendiente {
        background-color: #ffcdd2;
        /* Rojo claro */
    }
</style>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        require_once("../tools/navbar.php");
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        require_once("../tools/aside.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php
            require_once("../tools/breadcrumbs.php");
            ?>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listado de <?php echo $modulo ?></h3>

                        <div class="card-tools">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <table border="1" class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID Pago</th>
                                        <th>ID Usuario</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="lista-pagos">
                                    <!-- Las filas se agregarán dinámicamente con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
        require_once("../tools/footer.php");
        ?>
    </div>
    <!-- ./wrapper -->

    <?php
    require_once("../tools/scripts.php");
    ?>
    <!-- Sweet Alert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="pagos/pagos.js"></script>
</body>

</html>