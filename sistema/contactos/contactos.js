$(document).ready(function () {
    // Obtener los datos de los contáctos mediante AJAX
    $.ajax({
        url: 'contactos/obtenerContactos.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            // Llenar la tabla con los datos recibidos
            llenarTabla(data);
        },
        error: function (error) {
            // Manejo de errores
            Swal.fire('Error', 'Hubo un error al cargar los contáctos', 'error');
        }
    });
});

// Función para llenar la tabla con los datos de los contactos
function llenarTabla(data) {
    // Referencia a la tabla
    var tabla = $('#tablaContactos tbody');

    // Limpiar la tabla antes de llenarla
    tabla.empty();

    // Iterar sobre los datos y agregar filas a la tabla
    data.forEach(function (contacto) {
        var fila = '<tr>' +
            '<td>' + contacto.id + '</td>' +
            '<td>' + contacto.email + '</td>' +
            '<td>' + contacto.fecha + '</td>' +
            '<td><button class="btn btn-primary" onclick="verDetalle(' + contacto.id + ')">Ver</button>' + " " +
            '<button class="btn btn-danger" onclick="eliminarContacto(' + contacto.id + ')">Eliminar</button></td>' +
            '</tr>';

        tabla.append(fila);
    });
}

// Función para eliminar un contacto
function eliminarContacto(contactoID) {
    // Confirmar antes de eliminar
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el contacto permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar petición AJAX para eliminar el contacto
            $.ajax({
                url: 'contactos/eliminar_contacto.php?contactoID=' + contactoID,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Recargar la tabla después de la eliminación
                        $.ajax({
                            url: 'contactos/obtenerContactos.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                llenarTabla(data);
                                Swal.fire('Éxito', 'El contacto ha sido eliminado correctamente', 'success');
                            },
                            error: function (error) {
                                Swal.fire('Error', 'Hubo un error al cargar los contactos', 'error');
                            }
                        });
                    } else {
                        Swal.fire('Error', 'Hubo un error al eliminar el contacto', 'error');
                    }
                },
                error: function (error) {
                    // Manejo de errores
                    Swal.fire('Error', 'Hubo un error al eliminar el contacto', 'error');
                }
            });
        }
    });
}

// Función para mostrar el detalle del contacto en una ventana modal
function verDetalle(contactoID) {
    // Realizar petición AJAX para obtener los detalles del pedido
    $.ajax({
        url: 'contactos/detalles_contacto.php?contactoID=' + contactoID,
        type: 'GET',
        dataType: 'json',
        success: function (detalle) {
            // Llenar el contenido de la ventana modal con los detalles del contacto
            var modalContent = $('#detalleContactoModal .modal-body');
            modalContent.empty(); // Limpiar el contenido anterior

            // Iterar sobre los detalles y agregar la información al modal
            var detalleHTML =
                '<p><strong>Nombre:</strong> ' + detalle.nombre + '</p>' +
                '<p><strong>Teléfono:</strong> ' + detalle.telefono + '</p>' +
                '<p><strong>Email:</strong> ' + detalle.email + '</p>' +
                '<p><strong>Mensaje:</strong> ' + detalle.mensaje + '</p>' +
                '<hr>';

            modalContent.append(detalleHTML);
            // Mostrar la ventana modal
            $('#detalleContactoModal').modal('show');
        },
        error: function (error) {
            // Manejo de errores
            Swal.fire('Error', 'Hubo un error al cargar los detalles del contácto', 'error');
        }
    });
}

