// Declaración de la variable carritoProductos
var carritoProductos = [];

$(document).ready(function () {
    // ... (tu código existente)

    // Evento para mostrar el carrito y total
    $("#realizarPedidoBtn").click(function () {
        mostrarCarrito();
    });

    // Evento para realizar el pago
    $("#realizarPagoBtn").click(function () {
        if (carritoProductos.length > 0) {
            // Calcular el total a pagar
            var totalPagar = calcularTotalPagar();

            // Aquí puedes implementar la lógica para procesar el pago
            // Por ahora, mostraremos una alerta de éxito y vaciaremos el carrito
            Swal.fire({
                icon: 'success',
                title: 'Pago realizado',
                text: `Pago de $${totalPagar.toFixed(2)} realizado con éxito.`,
            });

            // Vaciar el carrito
            carritoProductos = [];

            // Actualizar la interfaz gráfica del carrito
            mostrarCarrito();
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Carrito vacío',
                text: 'Agrega productos al carrito antes de realizar un pago.',
            });
        }
    });

    // Función para mostrar el carrito y total
    function mostrarCarrito() {
        var carritoContainer = $("#carrito");
        carritoContainer.empty();

        // Iterar sobre los productos en el carrito y mostrarlos
        for (var i = 0; i < carritoProductos.length; i++) {
            var producto = carritoProductos[i];

            var itemCarrito = `
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${producto.nombre}</h5>
                            <p class="card-text">${producto.descripcion}</p>
                            <p class="card-text">Precio: $${producto.precio.toFixed(2)}</p>
                        </div>
                    </div>
                </div>
            `;

            carritoContainer.append(itemCarrito);
        }

        // Mostrar el total a pagar
        var totalPagar = calcularTotalPagar();
        $("#totalPagar").text(totalPagar.toFixed(2));
    }

    // Función para calcular el total a pagar
    function calcularTotalPagar() {
        var total = 0;
        for (var i = 0; i < carritoProductos.length; i++) {
            total += carritoProductos[i].precio;
        }
        return total;
    }

    // ... (tu código existente)
});
