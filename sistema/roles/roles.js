$(document).ready(function () {
    var usuariosTable = $('#usuariosTable').DataTable({
        ajax: 'roles/roles.php',
        columns: [
            { data: 'UsuarioID' },
            { data: 'Email' },
            {
                data: 'rol',
                render: function (data) {
                    // Usa emojis según el valor de 'rol'
                    return data == 0 ? '🧑' : '👨‍🏫';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button class="btn btn-warning btn-sm" onclick="editUser(' + row.UsuarioID + ')">Editar</button>' +
                        '<button class="btn btn-danger btn-sm ml-1" onclick="deleteUser(' + row.UsuarioID + ')">Eliminar</button>';
                }
            }
        ],
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando _PAGE_ de _PAGES_ páginas",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrados de _MAX_ registros totales)",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        responsive: true
    });

    // Función para abrir la ventana modal con los datos del usuario
    window.editUser = function (id) {
        // Obtener los datos del usuario por su ID (puedes hacer una nueva solicitud AJAX al servidor)
        // Convierte la cadena JSON a un objeto JavaScript
        var userData = JSON.parse(obtenerDatosUsuarioPorID(id));

        // Llenar los campos de la ventana modal con los datos del usuario
        $('#usuarioID').val(userData.UsuarioID);
        $('#email').val(userData.Email);
        // Configurar el valor seleccionado en el combo box de roles
        $('#rol').val(userData.Rol);

        // Supongamos que tienes el valor de 'verificado' en una variable llamada verificadoValue
        var verificadoValue = userData.Verificado;

        // Configurar el estado del radio button según 'verificadoValue'
        var $verificadoSi = $('#verificadoSi');
        var $verificadoNo = $('#verificadoNo');

        if (verificadoValue === 1) {
            $verificadoSi.prop('checked', true);
        } else {
            $verificadoNo.prop('checked', true);
        }

        // Mostrar la ventana modal
        $('#myModal').modal('show');
    };

    window.deleteUser = function (id) {
        // Utilizar SweetAlert para mostrar un mensaje de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realizar la eliminación
                eliminarUsuario(id);
            }
        });
    };

    // Función para eliminar un usuario
    function eliminarUsuario(id) {
        $.ajax({
            type: "POST",
            url: "roles/eliminar_usuario.php",
            data: { usuarioID: id },
            dataType: "json",
            success: function (response) {
                if (response.status === 'exito') {
                    var dataTable = $('#usuariosTable').DataTable();
                    dataTable.ajax.reload(); // Esto recarga los datos desde el servidor
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
            }
        });
    }


    // Función para obtener los datos del usuario por su ID
    function obtenerDatosUsuarioPorID(id) {
        var userData;
        $.ajax({
            url: 'roles/obtener_usuario.php',
            method: 'GET',
            data: { id: id },
            async: false, // Esperar la respuesta para llenar userData
            success: function (response) {
                userData = response;
            },
            error: function () {
                alert('Error al obtener datos del usuario.');
            }
        });
        return userData;
    }

    // Función para actualizar los datos del usuario en el servidor
    $("#usuarioForm").submit(function (event) {
        event.preventDefault();

        var usuarioID = $("#usuarioID").val();
        var email = $("#email").val();
        var verificado = $("input[name='verificado']:checked").val();
        var rol = $("#rol").val();

        $.ajax({
            type: "POST",
            url: "roles/actualizar_usuario.php",
            data: {
                usuarioID: usuarioID,
                email: email,
                verificado: verificado,
                rol: rol
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'exito') {
                    var dataTable = $('#usuariosTable').DataTable();
                    dataTable.ajax.reload(); // Esto recarga los datos desde el servidor
                    $('#myModal').modal('hide'); // Cerrar la ventana modal
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
            }
        });
    });
});