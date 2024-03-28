
// Al cargar la página
$(document).ready(function () {
    // Obtener los datos de los pedidos mediante AJAX
    $.ajax({
        url: 'pedidos/obtener_pedidos.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Llenar la tabla con los datos recibidos
            llenarTabla(data);
        },
        error: function (error) {
            // Manejo de errores
            Swal.fire('Error', 'Hubo un error al cargar los pedidos', 'error');
        }
    });
});

// Función para llenar la tabla con los datos de los pedidos
function llenarTabla(data) {
    // Referencia a la tabla
    var tabla = $('#tablaPedidos tbody');

    // Limpiar la tabla antes de llenarla
    tabla.empty();

    // Iterar sobre los datos y agregar filas a la tabla
    data.forEach(function (pedido) {
        var fila = '<tr>' +
            '<td>' + pedido.PedidoID + '</td>' +
            '<td>' + pedido.FechaPedido + '</td>' +
            '<td><button class="btn btn-primary" onclick="verDetalle(' + pedido.PedidoID + ')">Ver</button></td>' +
            '</tr>';

        tabla.append(fila);
    });
}

// Función para mostrar el detalle del pedido en una ventana modal
function verDetalle(pedidoID) {
    // Realizar petición AJAX para obtener los detalles del pedido
    $.ajax({
        url: 'pedidos/detalles_pedido.php?pedidoID=' + pedidoID,
        type: 'GET',
        dataType: 'json',
        success: function (detalles) {
            // Llenar el contenido de la ventana modal con los detalles del pedido
            var modalContent = $('#detallePedidoModal .modal-body');
            modalContent.empty(); // Limpiar el contenido anterior

            // Iterar sobre los detalles y agregar la información al modal
            detalles.forEach(function (detalle) {
                var detalleHTML =
                    '<img src="' + '../' + detalle.ImagenURL + '" alt="Imagen del Producto" class="img-thumbnail" width="100px">' +
                    '<p><strong>Producto:</strong> ' + detalle.NombreProducto + '</p>' +
                    '<p><strong>Descripción:</strong> ' + detalle.DescProducto + '</p>' +
                    '<p><strong>Cantidad:</strong> ' + detalle.Cantidad + '</p>' +
                    '<p><strong>Precio:</strong> $' + detalle.Precio + '</p>' +
                    '<hr>';  // Agrega una línea horizontal después de cada detalle
                modalContent.append(detalleHTML);
            });

            // Mostrar la ventana modal
            $('#detallePedidoModal').modal('show');
        },
        error: function (error) {
            // Manejo de errores
            Swal.fire('Error', 'Hubo un error al cargar los detalles del pedido', 'error');
        }
    });
}

