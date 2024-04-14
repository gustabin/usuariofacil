En cPanel, la gestión de permisos de archivos generalmente se realiza a través del Administrador de Archivos. A continuación, te proporcionaré una guía básica sobre cómo ajustar los permisos de un archivo en cPanel:

1. **Inicia Sesión en cPanel:**
   - Accede a cPanel utilizando tu nombre de usuario y contraseña proporcionados por tu proveedor de alojamiento.

2. **Encuentra y Abre el Administrador de Archivos:**
   - Busca la sección "Archivos" en el panel principal de cPanel y selecciona "Administrador de Archivos".

3. **Navega a la Ubicación del Archivo:**
   - Utiliza el Administrador de Archivos para navegar hasta la ubicación del archivo `config.php`. Esto podría ser dentro del directorio principal de tu sitio web.

4. **Selecciona el Archivo `config.php`:**
   - Haz clic derecho en el archivo `config.php` y selecciona "Cambiar Permisos" o "Permisos" en el menú contextual.

5. **Ajusta los Permisos:**
   - En la ventana emergente de "Cambiar Permisos", verás una interfaz gráfica o campos numéricos donde puedes ajustar los permisos. Establece los permisos de manera que solo el propietario tenga permisos de lectura.

6. **Guardar Cambios:**
   - Guarda los cambios y cierra la ventana.

Si estás utilizando cPanel, la interfaz del Administrador de Archivos puede variar ligeramente según la versión específica de cPanel proporcionada por tu proveedor de alojamiento. Sin embargo, la funcionalidad básica de cambiar permisos debería estar disponible.

Recuerda que establecer los permisos a `400` permite la lectura solo para el propietario. Si el servidor web utiliza un usuario específico (por ejemplo, `www-data` para Apache), asegúrate de que ese usuario sea el propietario del archivo.

Si tienes dificultades específicas o si la interfaz de cPanel es diferente, puedes consultar la documentación de cPanel de tu proveedor de alojamiento o comunicarte con su soporte técnico para obtener ayuda detallada.