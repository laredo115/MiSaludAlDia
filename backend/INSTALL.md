# Instalación de Mi Salud al Día — Reto 3

## 1. Entorno utilizado

- Windows.
- PHP 8.2.12.
- Composer 2.9.7.
- Laravel Framework 12.70.0.
- Laravel Fortify 1.41.0 para registro e inicio de sesión.
- MySQL Community Server 8.0.42, puerto 3306.
- Apache 2.4.58 de XAMPP.
- OpenSSL 3.1.3.
- mkcert 1.4.4 para certificados locales.
- Navegadores probados: Microsoft Edge y Google Chrome.

El backend se encuentra en `backend/`, en la rama `reto3`.
La versión estática del Reto 2 se conserva en la rama `main`.

## 2. Obtener el proyecto

En PowerShell:

```powershell
git clone --branch reto3 https://github.com/laredo115/MiSaludAlDia.git
cd MiSaludAlDia/backend
composer install
Copy-Item .env.example .env
php artisan key:generate
```

PHP debe estar disponible en PATH. En el equipo utilizado se encuentra
en `C:\xampp\php\php.exe`.

La interfaz utiliza Blade y CSS en `public/css/salud.css`.
No necesita ejecutar Vite para estas pantallas.

## 3. Crear la base de datos

Iniciar el servicio MySQL80. Si está detenido, abrir PowerShell como
administrador y ejecutar:

```powershell
Start-Service MySQL80
```

Entrar al cliente MySQL con una cuenta administradora:

```powershell
& "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p
```

Dentro del cliente MySQL, ejecutar el siguiente SQL. Reemplazar
`CAMBIAR_POR_CLAVE_PROPIA` por una contraseña privada:

```sql
CREATE DATABASE misaludaldia
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

CREATE USER 'misalud_app'@'localhost'
    IDENTIFIED BY 'CAMBIAR_POR_CLAVE_PROPIA';

GRANT ALL PRIVILEGES ON misaludaldia.*
    TO 'misalud_app'@'localhost';

EXIT;
```

Estos comandos corresponden a una instalación nueva.
No volver a crear la base ni el usuario si ya existen.

## 4. Configurar Laravel

Editar el archivo `backend/.env` en el editor.
Las siguientes líneas son configuración del archivo, no comandos:

```dotenv
APP_NAME="Mi Salud al Día"
APP_ENV=local
APP_DEBUG=false
APP_URL=https://misalud.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=misaludaldia
DB_USERNAME=misalud_app
DB_PASSWORD="CAMBIAR_POR_CLAVE_PROPIA"

SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

Usar la misma contraseña asignada al usuario de MySQL.
Conservar las demás variables y la APP_KEY generada.

No publicar `.env`, contraseñas ni claves privadas en Git.

En PowerShell, dentro de `backend`, ejecutar:

```powershell
php artisan config:clear
php artisan migrate
php artisan migrate:status
```

Las migraciones de `database/migrations/` crean las tablas,
índices y relaciones. Las tablas principales son `users`,
`medicamentos`, `tomas` y `citas`.

Cada medicamento y cita pertenece a un usuario.
Cada toma pertenece a un medicamento.
El índice único de medicamento y fecha evita tomas diarias duplicadas.

La configuración de Fortify habilita el registro y redirige
al usuario autenticado a `/panel`.

## 5. Registrar el dominio local

Abrir el Bloc de notas como administrador y editar:

`C:\Windows\System32\drivers\etc\hosts`

Agregar:

```text
127.0.0.1 misalud.test
```

El dominio solo funciona en los equipos donde se configure.
No corresponde a un sitio publicado en Internet.

## 6. Crear el certificado local

En PowerShell:

```powershell
winget install --id FiloSottile.mkcert --exact --source winget
```

Abrir una nueva ventana de PowerShell y ejecutar:

```powershell
mkcert -install
New-Item -ItemType Directory -Force C:\xampp\apache\conf\ssl-local
mkcert -cert-file C:\xampp\apache\conf\ssl-local\misalud.test.pem -key-file C:\xampp\apache\conf\ssl-local\misalud.test-key.pem misalud.test
```

Aceptar la instalación de la autoridad local creada por mkcert.
Si Windows solicita elevación, autorizarla.

Los certificados son para desarrollo local.
No compartir las claves privadas, incluida `rootCA-key.pem`.

## 7. Configurar Apache

Respaldar la configuración existente antes de editarla.

En `C:\xampp\apache\conf\httpd.conf`, comprobar que estén habilitados:

```apache
LoadModule ssl_module modules/mod_ssl.so
LoadModule socache_shmcb_module modules/mod_socache_shmcb.so
LoadModule headers_module modules/mod_headers.so
LoadModule rewrite_module modules/mod_rewrite.so

Include conf/extra/httpd-vhosts.conf
Include conf/extra/httpd-ssl.conf
```

No duplicar estas líneas si ya existen.
En `httpd-ssl.conf` debe existir una sola directiva `Listen 443`.

Agregar los siguientes bloques a
`C:\xampp\apache\conf\extra\httpd-vhosts.conf`.
Ajustar las rutas a la ubicación real del proyecto.
Conservar los bloques de otros proyectos.

```apache
<VirtualHost *:80>
    ServerName misalud.test
    Redirect permanent / https://misalud.test/
</VirtualHost>

<VirtualHost *:443>
    ServerName misalud.test
    DocumentRoot "C:/Users/crimi/Documents/Proyectos/MiSaludAlDia/backend/public"

    SSLEngine on
    SSLCertificateFile "C:/xampp/apache/conf/ssl-local/misalud.test.pem"
    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl-local/misalud.test-key.pem"

    Header always set Content-Security-Policy "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'"
    Header always set Strict-Transport-Security "max-age=31536000"
    Header always set X-Content-Type-Options "nosniff"
    Header always set Referrer-Policy "same-origin"

    <Directory "C:/Users/crimi/Documents/Proyectos/MiSaludAlDia/backend/public">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require local
        DirectoryIndex index.php
    </Directory>

    ErrorLog "logs/misalud-reto3-ssl-error.log"
    CustomLog "logs/misalud-reto3-ssl-access.log" combined
</VirtualHost>
```

Esta configuración restringe el acceso al equipo local.
Apache debe servir únicamente la carpeta `backend/public`.

Validar en PowerShell:

```powershell
& "C:\xampp\apache\bin\httpd.exe" -t
& "C:\xampp\apache\bin\httpd.exe" -S
```

Con `Syntax OK`, reiniciar Apache desde XAMPP.
Abrir `https://misalud.test/login`.

## 8. Verificación

Comprobar la redirección HTTP:

```powershell
curl.exe -I http://misalud.test/login
```

Resultado esperado: `301 Moved Permanently` y
`Location: https://misalud.test/login`.

Comprobar HTTPS y las cabeceras:

```powershell
curl.exe --ssl-revoke-best-effort -I https://misalud.test/login
```

La opción de revocación permite certificados locales sin información
de revocación disponible; mantiene la validación del certificado.

Resultado esperado: `200 OK`, Content-Security-Policy,
Strict-Transport-Security, X-Content-Type-Options y Referrer-Policy.

## 9. Pruebas funcionales

Realizar con datos ficticios en Edge y Chrome:

1. Registrar una cuenta, cerrar sesión e iniciar sesión.
2. Confirmar que `/panel` requiere autenticación.
3. Guardar y eliminar medicamentos.
4. Marcar una toma dos veces y comprobar el mensaje de duplicado.
5. Guardar y eliminar citas.
6. Comprobar que dos cuentas muestran sus propios registros.
7. Abrir `/privacidad` y `/terminos` sin iniciar sesión.

El registro de tomas utiliza la fecha de la zona horaria configurada
en Laravel; revisar `timezone` en `config/app.php` si se necesita
ajustar el día local de uso.

## 10. Rendimiento

En Chrome, abrir `/login` sin sesión y ejecutar Lighthouse con:

- Modo Navigation.
- Dispositivo Mobile.
- Performance, Accessibility y Best Practices.

En la ejecución reportada durante las pruebas se obtuvieron
100/100 en las tres categorías. Los resultados pueden variar
según el equipo y las condiciones de ejecución.

Conservar la captura y el informe HTML como evidencias.

## 11. Alcance

Prototipo académico local para organizar registros personales.
No proporciona diagnósticos ni recomendaciones de tratamiento.
Consultar el Aviso de privacidad y los Términos de uso,
disponibles en el pie de página.