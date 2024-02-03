<?php
$nombre_usuario = "Nombre del usuario";
$modulo = "Perfil";
require_once("../tools/header.php");
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
                    <div class="card-body" id="profileCard">
                        <!-- Aquí se mostrarán los datos del perfil -->
                        <h5>Nombre: <span id="nombreSpan"></span></h5>
                        <h5>Apellido: <span id="apellidoSpan"></span></h5>
                        <img src="" id="avatarSpan" alt="Avatar" class="img-fluid mb-3" style="width: 128px; height: 128px;">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar Perfil</button>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <!-- Puedes agregar pie de página si es necesario -->
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

                <!-- Modal -->
                <div class="modal fade" id="myModal" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Perfil</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="perfilForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido:</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="avatarURL">Avatar:</label>
                                        <input type="file" class="form-control" id="avatarURL" name="avatarURL">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="perfil/perfil.js"></script>
</body>

</html>