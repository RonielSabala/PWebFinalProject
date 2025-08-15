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

## **1.** Configuración de las credenciales

### **1.1.** Credenciales de base de datos

Crea un archivo `.env` en la ruta `src/config/` con las siguientes variables de conexión para la base de datos.

```
HOST='TU_HOST'
USER='TU_USUARIO'
PASS='TU_CONTRASEÑA'
```

### **1.2.** Credenciales de Google y Microsoft

En el archivo `.env` creado anteriormente, crea las siguientes variables para poder usar los servicios de Google y Microsoft.

```
GOOGLE_CLIENT_ID='TU_GOOGLE_CLIENT_ID'
GOOGLE_CLIENT_SECRET='TU_GOOGLE_CLIENT_SECRET'

MICROSOFT_CLIENT_ID='TU_MICROSOFT_CLIENT_ID'
MICROSOFT_CLIENT_SECRET='TU_MICROSOFT_CLIENT_SECRET'
```

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
