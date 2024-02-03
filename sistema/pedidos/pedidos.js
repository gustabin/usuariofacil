$(document).ready(function () {
    $("#pedidoForm").submit(function (event) {
        event.preventDefault(); // Detener el envío del formulario convencional
        var producto = $("#selectProducto").val();
        var cantidad = $("#inputCantidad").val();

        // Validar que se haya seleccionado un producto y la cantidad sea válida
        if (!producto || cantidad <= 0) {
            // Mostrar SweetAlert de error
            Swal.fire({
                icon: 'error',
                title: 'Error en el Pedido',
                text: 'Selecciona un producto y especifica una cantidad válida.',
            });
            return;
        }
        // Enviar solicitud AJAX para procesar el pedido
        $.ajax({
            type: "POST",
            url: "pedidos/registrar_pedido.php", // Especifica la ruta a tu controlador PHP en el backend
            data: { producto: producto, cantidad: cantidad },
            success: function (response) {
                // console.log(response);
                // Procesar la respuesta del servidor
                if (response.status === 'exito') {
                    Swal.fire('Éxito', response.message, 'success');
                    $("#pedidoForm")[0].reset();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                // Mostrar SweetAlert de error en caso de fallo en la solicitud AJAX
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Solicitud',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                });
            }
        });
    });
});