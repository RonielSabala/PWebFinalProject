# Proyecto final de Programación Web

### App de incidencias

- Integrantes del proyecto

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

## 1. Conexión con la base de datos

Crea un archivo `.env` en la ruta `src/config` y crea las variables de conexión.

```
HOST='TU_HOST'
USER='TU_USUARIO'
PASS='TU_CONTRASEÑA'
```

## 2. Creación de la base de datos

Para ello, ejecuta el siguiente comando:

```bash
php src/db/install.php
```

## 3. Instalación de librerías necesarias

En la raíz del proyecto (`src/`), ejecuta los siguientes comandos:

```bash
composer require google/apiclient
composer require league/oauth2-client
composer require vlucas/phpdotenv
```

## 4. Ejecución

Para iniciar el servidor PHP, ejecuta:

```bash
php -S localhost:1111 -t src/public
```

## 5. Inicio de sesión

Regístrate o inicia sesión con **Google/Microsoft** para acceder al sistema.

---

> ¡Ya tienes todo lo necesario para usar nuestro sistema!
