CORS (Cross-Origin Resource Sharing) es una política de seguridad implementada por los navegadores para controlar cómo los recursos web en una página web pueden ser solicitados desde otro dominio diferente al de la propia página. Aquí tienes ejemplos de cómo implementar CORS en el lado del servidor utilizando PHP y también cómo configurar el encabezado CORS en el lado del cliente utilizando JavaScript.

### Implementación CORS en el lado del servidor (PHP):

Para permitir solicitudes CORS desde un dominio específico en el lado del servidor, puedes configurar los encabezados de respuesta en tu script PHP de la siguiente manera:

```php
<?php
// Permitir solicitudes desde un dominio específico
header("Access-Control-Allow-Origin: http://dominio-permitido.com");

// Permitir solicitudes con ciertos métodos (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permitir incluir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Content-Type");

// Indicar si se pueden incluir cookies en la solicitud
header("Access-Control-Allow-Credentials: true");

// Establecer el tiempo máximo que los resultados pueden ser almacenados en caché (en segundos)
header("Access-Control-Max-Age: 3600");

// Manejar la solicitud OPTIONS enviada por el navegador antes de la solicitud real
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

// Resto del código PHP aquí...
?>
```

Asegúrate de ajustar los valores de los encabezados según tus necesidades específicas.

### Configuración CORS en el lado del cliente (JavaScript):

En el lado del cliente, puedes configurar CORS al realizar solicitudes mediante JavaScript. Aquí hay un ejemplo utilizando la API Fetch:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORS Example</title>
</head>
<body>

<script>
// Realizar una solicitud GET con CORS
fetch('http://servidor-api.com/data', {
    method: 'GET',
    headers: {
        'Origin': 'http://dominio-permitido.com',
        'Content-Type': 'application/json',
        // Agregar otros encabezados según sea necesario
    },
    credentials: 'include', // Incluir cookies en la solicitud si es necesario
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
.catch(error => {
    console.error('Error:', error);
});
</script>

</body>
</html>
```

Asegúrate de ajustar el valor del encabezado 'Origin' y otros encabezados según sea necesario. Además, ten en cuenta que en una solicitud CORS con credenciales (`credentials: 'include'`), el servidor debe permitir el uso de cookies en la solicitud (`Access-Control-Allow-Credentials: true`).