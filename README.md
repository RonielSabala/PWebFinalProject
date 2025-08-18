# Incidencias RD

### Proyecto final de Programación Web

- Integrantes

> **Roniel Antonio Sabala Germán**  
>  Matrícula: `20240212`
>
> **Jeremy Reyes González**  
>  Matrícula: `20240224`
>
> **Abel Eduardo Martínez Robles**  
>  Matrícula: `20240227`

---

# Instrucciones para ejecutar el proyecto

_Requisitos_:

- MySQL
- PHP 7.4+
- Composer

## **1.** Creación de credenciales

Crea un archivo `.env` en la carpeta `src/config` y crea las siguientes variables.

### **1.1.** Credenciales para la base de datos

```
HOST='TU_HOST'
USER='TU_USUARIO'
PASS='TU_CONTRASEÑA'
```

### **1.2.** Credenciales para el envio de correos

```
MAIL_USER='TU_EMAIL_DE_GOOGLE'
MAIL_PASS='TU_CONTRASEÑA_DE_APLICACIÓN'
```

Para obtener `MAIL_PASS` haz lo siguiente:

1. Ingresa a la [Configuración de seguridad de Google](https://myaccount.google.com/security).

2. Activa la verificación en dos pasos de tu cuenta de google (la misma que pusiste en `MAIL_USER`).

3. Ingresa a [Contraseñas de aplicaciones](https://myaccount.google.com/apppasswords).

4. Escribe un nombre para crear una nueva contraseña específica para la app.

5. Copia el código generado y ponlo en `MAIL_PASS`.

### **1.3.** Credenciales para iniciar sesión con Google

```
GOOGLE_CLIENT_ID='TU_GOOGLE_CLIENT_ID'
GOOGLE_CLIENT_SECRET='TU_GOOGLE_CLIENT_SECRET'
```

Para obtener las credenciales haz lo siguiente:

1. Ve a [Google Cloud Console](https://console.cloud.google.com/).

2. Inicia sesión o regístrate.

3. Dirígete a **APIs & Services**, luego ve a **Credentials**.

4. Crea un **OAuth Client ID** tipo Web application.

5. Copia el siguiente callback y ponlo en donde dice `Redirect URI`.

```
http://localhost:1111/auth/GoogleCallbackController.php
```

6. Copia el `CLIENT_ID` y el `CLIENT_SECRET`.

### **1.4.** Credenciales para iniciar sesión con Microsoft

```
MICROSOFT_CLIENT_ID='TU_MICROSOFT_CLIENT_ID'
MICROSOFT_CLIENT_SECRET='TU_MICROSOFT_CLIENT_SECRET'
```

Para obtener las credenciales haz lo siguiente:

1. Inicia sesión o regístrate en [Azure Portal](https://portal.azure.com/auth/login/).

2. Ve a **Azure Active Directory**, luego ve a **App registrations** y registra una nueva app.

3. Copia el siguiente callback y ponlo en donde dice `Redirect URI`.

```
http://localhost:1111/auth/MicrosoftCallbackController.php
```

4. Copia el `Application (client) ID` y el `Certificates & secrets`.

## **2.** Creación de la base de datos

Para ello, ejecuta el siguiente comando:

```bash
php src/db/install.php
```

## **3.** Instalación de librerías necesarias

En la raíz del proyecto (`src/`), ejecuta los siguientes comandos:

```bash
composer require google/apiclient
composer require league/oauth2-client
composer require vlucas/phpdotenv
```

## **4.** Ejecución

Para iniciar el servidor PHP, ejecuta:

```bash
php -S localhost:1111 -t src/public
```

## **5.** Inicio de sesión

Regístrate o inicia sesión con **Google/Microsoft** para acceder al sistema.

---

> ¡Listo, esos fueron todos los pasos!
