<?php
$nombre_usuario = "Nombre del usuario";
$modulo = "Pagos";
require_once("../tools/header.php");
// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Obtener el ID del usuario logueado
$usuarioID = $_SESSION['usuarioID'];

// Obtener productos disponibles desde la tabla Pedidos para el usuario logueado
$queryProductos = "SELECT DISTINCT Producto FROM Pedidos WHERE UsuarioID = ?";
$stmtProductos = $conexion->prepare($queryProductos);

if (!$stmtProductos) {
    die('Error en la preparación de la consulta: ' . $conexion->error);
}

$stmtProductos->bind_param('i', $usuarioID);
$stmtProductos->execute();
$resultProductos = $stmtProductos->get_result();

// Cerrar la conexión
$stmtProductos->close();
$conexion->close();
?>

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
                        <h3 class="card-title"><?php echo $modulo ?></h3>

                        <div class="card-tools">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form id="pagoForm" class="row justify-content-center align-items-center">
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <label for="selectProductoPago" class="sr-only">Producto:</label>
                                    <select class="form-control" id="selectProductoPago" name="producto" required>
                                        <?php
                                        while ($row = $resultProductos->fetch_assoc()) {
                                            echo "<option value='" . $row['Producto'] . "'>" . $row['Producto'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 mb-3">
                                    <label for="inputMonto" class="sr-only">Monto:</label>
                                    <input type="number" step="0.01" class="form-control" id="inputMonto" name="monto" min="0.01" required>
                                </div>
                                <div class="form-group col-12 col-md-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Realizar Pago</button>
                                </div>
                            </form>
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