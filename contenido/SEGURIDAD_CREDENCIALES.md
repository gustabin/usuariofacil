Cuando se trata de almacenar credenciales de base de datos de manera segura, una práctica común es utilizar un archivo de configuración que esté fuera del directorio público de tu aplicación web. Aquí hay un ejemplo de cómo podrías estructurar tus archivos para lograr esto:

### Estructura de Carpetas:

Supongamos que tienes la siguiente estructura de carpetas:

```
/proyecto
    /config
        config.php
    /public_html
        index.php
```

### `config.php` - Archivo de Configuración (fuera del directorio público):

```php
<?php
// Definir las credenciales de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'nombre_usuario');
define('DB_PASSWORD', 'contraseña');
define('DB_NAME', 'nombre_de_la_base_de_datos');
?>
```

### `index.php` - Archivo principal (dentro del directorio público):

```php
<?php
// Incluir el archivo de configuración
require_once('../config/config.php');

// Crear la conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Resto del código PHP...
?>
```

### Consideraciones Importantes:

1. **Ubicación del Archivo de Configuración:**
   - Asegúrate de que el archivo de configuración esté fuera del directorio público. De esta manera, no es accesible directamente desde el navegador.

2. **Permisos de Archivo:**
   - Ajusta los permisos del archivo de configuración para que solo el servidor web tenga permisos de lectura. Esto ayuda a evitar que personas no autorizadas accedan a las credenciales.

3. **No Imprimas Credenciales en el Código Fuente:**
   - No incluyas directamente las credenciales en el código fuente del archivo de configuración. Define constantes o variables que contengan las credenciales, pero no las imprimas en el código.

4. **Encriptación y Seguridad Adicional:**
   - Considera medidas adicionales de seguridad, como la encriptación de las credenciales almacenadas, especialmente si el servidor es compartido o si existe la posibilidad de acceso no autorizado.

Este enfoque proporciona una capa adicional de seguridad al almacenar las credenciales fuera del alcance del público. Asegúrate de ajustar los detalles según las necesidades y la configuración específica de tu aplicación.