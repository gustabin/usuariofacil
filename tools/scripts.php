    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        cargarPerfil();

        function cargarPerfil() {
            // Peticion AJAX para obtener el perfil del usuario
            $.ajax({
                type: 'GET',
                url: 'perfil/perfil_usuario.php',
                success: function(response) {
                    // El servidor responderá con los datos del perfil en formato JSON
                    const perfilDatos = JSON.parse(response);

                    $("#nombre_usuario").text(perfilDatos.nombre + " " + perfilDatos.apellido);

                    if (perfilDatos.avatarURL) {
                        // Obtiene el elemento de imagen del usuario
                        const imagenUsuario = $(".img-circle.elevation-2");

                        // Actualiza la ruta de la imagen con la URL obtenida del perfilDatos.avatarURL
                        imagenUsuario.attr("src", "perfil/" + perfilDatos.avatarURL);
                    }
                },
                error: function() {
                    // Manejo de errores, puedes mostrar un mensaje o realizar otras acciones
                    console.error('Error al cargar el perfil del usuario');
                }
            });
        }
    </script>