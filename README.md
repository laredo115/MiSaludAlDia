# Mi Salud al Día

Aplicación web académica para organizar medicamentos con un horario
diario, registrar las tomas realizadas y guardar citas médicas.

## Propósito

Facilitar la organización de la rutina de salud mediante una interfaz
sencilla y adaptable a computadoras y celulares.

La aplicación registra indicaciones proporcionadas por el usuario.
No recomienda tratamientos ni modifica dosis.

## Funciones

- Agregar y eliminar medicamentos.
- Registrar una toma por medicamento al día.
- Deshacer un registro de toma.
- Agregar y eliminar citas médicas.
- Guardar preguntas para la consulta.
- Mostrar contadores de medicamentos, tomas y próximas citas.
- Conservar los datos en el navegador mediante localStorage.

## Tecnologías

- HTML5.
- CSS3.
- JavaScript.
- Node.js y npm para las herramientas de minificación.
- clean-css-cli 5.4.2 para CSS.
- Terser para JavaScript.

## Organización

- index.html: estructura de la aplicación.
- css/styles.css: estilos originales.
- css/styles.min.css: estilos minificados.
- js/app.js: código original.
- js/app.min.js: código minificado.
- img/: carpeta reservada para imágenes.
- package.json y package-lock.json: dependencias de desarrollo.
- .gitignore: exclusiones del repositorio.

## Ejecución inicial

Abrir index.html en un navegador moderno.

El documento HTML utiliza las versiones minificadas del CSS
y JavaScript.

## Optimización

Se conservaron los archivos originales para facilitar la edición
y se generaron versiones minificadas para su distribución.

| Archivo | Original | Minificado | Reducción |
|---|---:|---:|---:|
| CSS | 5732 bytes | 4212 bytes | 26.5 % |
| JavaScript | 9230 bytes | 5765 bytes | 37.5 % |

Comandos utilizados en PowerShell:

    npm.cmd ci
    npx.cmd cleancss -o css/styles.min.css css/styles.css
    npx.cmd terser js/app.js --compress --mangle --output js/app.min.js

Después de modificar los archivos originales, se deben volver
a generar sus versiones minificadas.

## Revisión de dependencias

Se ejecutó npm.cmd audit. Tras ajustar clean-css-cli a la
versión 5.4.2, el resultado fue 0 vulnerabilidades reportadas
el 6 de octubre de 2026.

## Pruebas funcionales

Se comprobó el registro de medicamentos, tomas y citas,
la actualización de contadores y la eliminación de registros.

## Almacenamiento y alcance

Los datos se guardan únicamente en el navegador utilizado.
No se sincronizan entre dispositivos y pueden perderse al
borrar los datos del navegador.

Para las demostraciones se utiliza información ficticia.
Esta versión no incluye notificaciones ni cuentas de usuario.

## Etapas pendientes

- Empaquetado de la versión para distribución.
- Publicación del repositorio en GitHub o GitLab.
- Configuración y comprobación del despliegue con Apache.
## Despliegue local con Apache

La aplicación se sirve mediante Apache de XAMPP en el puerto 80.

- URL: http://localhost/misalud/
- Directorio del proyecto: C:/Users/crimi/Documents/Proyectos/MiSaludAlDia
- Configuración: C:/xampp/apache/conf/extra/httpd-vhosts.conf

Se configuró un VirtualHost para localhost y un Alias /misalud
que apunta al directorio del proyecto. DirectoryIndex establece
index.html como página inicial y Require local limita el acceso
al equipo local.

La configuración se comprobó con:

```powershell
& C:\xampp\apache\bin\httpd.exe -t
& C:\xampp\apache\bin\httpd.exe -S
```

La comprobación de sintaxis devolvió Syntax OK y la aplicación
se abrió correctamente desde http://localhost/misalud/.

## Empaquetado

El paquete MiSaludAlDia-v1.0.0.zip contiene:

- index.html
- css/styles.min.css
- js/app.min.js

Su tamaño es de 5,628 bytes. Se creó con Compress-Archive
y se verificó extrayéndolo con Expand-Archive.

Para utilizarlo, extraer el ZIP en el directorio elegido
y configurar Apache para servir ese directorio.