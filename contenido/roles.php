<?php
$nombre_usuario = "Nombre del usuario";
$modulo = "Roles";
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
                        <h3 class="card-title"><?php echo $modulo ?> de usuario</h3>

                        <div class="card-tools">

                        </div>
                    </div>
                    <div class="card-body" id="profileCard">
                        <!-- roles.html -->
                        <table id="usuariosTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
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
                                <h4 class="modal-title">Editar Usuario</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="usuarioForm" method="POST">
                                    <div class="form-group">
                                        <label for="usuarioID">ID:</label>
                                        <input type="text" class="form-control" id="usuarioID" name="usuarioID" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="verificadoSwitch" class="form-check-label">Verificado:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="verificadoSi" name="verificado" value="1">
                                            <label class="form-check-label" for="verificadoSi">Sí</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="verificadoNo" name="verificado" value="0">
                                            <label class="form-check-label" for="verificadoNo">No</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="rol">Rol:</label>
                                        <!-- Agrega un select con opciones de roles -->
                                        <select class="form-control" id="rol" name="rol" required>
                                            <!-- Opciones de roles se pueden cargar dinámicamente desde la base de datos -->
                                            <option value="0" selected>Usuario</option>
                                            <option value="1">Administrador</option>
                                            <!-- ... más opciones ... -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <!-- Asegúrate de cargar jQuery primero -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Luego carga DataTable -->
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <!-- Sweet Alert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="roles/roles.js"></script>
</body>

</html>