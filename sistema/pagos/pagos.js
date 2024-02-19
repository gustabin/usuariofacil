$(document).ready(function () {
    // Realizar una solicitud AJAX para obtener los pagos
    $.ajax({
        url: 'pagos/listado_pagos.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Manipular los datos y mostrarlos en la interfaz
            if (data.error) {
                // Manejar error si lo hay
                console.error(data.error);
            } else {
                // Procesar datos y mostrar en la interfaz
                mostrarListadoPagos(data);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
});

function mostrarListadoPagos(pagos) {
    // Seleccionar el contenedor donde se mostrará la lista
    var listaPagos = $('#lista-pagos');

    // Iterar sobre los pagos y construir la tabla
    pagos.forEach(function (pago) {
        // Crear una fila para cada pago
        var fila = $('<tr>');

        // Colorear la fila según el estado del pago
        if (pago.Pagado == 1) {
            fila.addClass('pago-realizado');
        } else {
            fila.addClass('pago-pendiente');
        }

        // Añadir celdas con información del pago
        fila.append('<td>' + pago.PagoID + '</td>');
        fila.append('<td>' + pago.UsuarioID + '</td>');
        fila.append('<td>$' + pago.Monto + '</td>');
        fila.append('<td>' + (pago.Pagado == 1 ? 'Realizado' : 'Pendiente') + '</td>');

        // Añadir la fila a la tabla
        listaPagos.append(fila);
    });
}


// $(document).ready(function () {
//     $("#pagoForm").submit(function (event) {
//         event.preventDefault();

//         var producto = $("#selectProductoPago").val();
//         var monto = $("#inputMonto").val();

//         if (!producto || monto <= 0) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error en el Pago',
//                 text: 'Selecciona un producto y especifica un monto válido.',
//             });
//             return;
//         }

//         $.ajax({
//             type: "POST",
//             url: "pagos/registrar_pago.php",
//             data: { producto: producto, monto: monto },
//             success: function (response) {
//                 if (response.status === 'exito') {
//                     Swal.fire('Éxito', response.message, 'success');
//                     $("#pagoForm")[0].reset();
//                 } else {
//                     Swal.fire('Error', response.message, 'error');
//                 }
//             },
//             error: function () {
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Error en la Solicitud',
//                     text: 'Hubo un problema al comunicarse con el servidor.',
//                 });
//             }
//         });
//     });
// });
