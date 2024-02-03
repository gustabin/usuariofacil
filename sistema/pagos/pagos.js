$(document).ready(function () {
    $("#pagoForm").submit(function (event) {
        event.preventDefault();

        var producto = $("#selectProductoPago").val();
        var monto = $("#inputMonto").val();

        if (!producto || monto <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error en el Pago',
                text: 'Selecciona un producto y especifica un monto válido.',
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "pagos/registrar_pago.php",
            data: { producto: producto, monto: monto },
            success: function (response) {
                if (response.status === 'exito') {
                    Swal.fire('Éxito', response.message, 'success');
                    $("#pagoForm")[0].reset();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Solicitud',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                });
            }
        });
    });
});
