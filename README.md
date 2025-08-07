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
- Composer

## 1. Conexión con la base de datos

Configura los datos de conexión en el archivo `src/config/db.php`.

## 2. Creación de la base de datos

Para ello, ejecuta el siguiente comando:

```bash
php src/db/install.php
```

## 3. Instalación de librerías necesarias

En la raíz del proyecto (`src/`), ejecuta los siguientes comandos:

```bash
composer require google/apiclient:"^2.0"
composer require league/oauth2-client
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
