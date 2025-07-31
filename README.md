# Proyecto final de Programación Web

### App de incidencias

- Integrantes del proyecto

> **Roniel Antonio Sabala Germán**  
>  Matrícula: `20240212`
>
> **Jeremy Reyes González**  
>  Matrícula: `20240227`
>
> **Abel Eduardo Martínez Robles**  
>  Matrícula: `20240227`

---

# Instrucciones para la ejecución el proyecto

_Requisitos_:

- MySQL
- Composer

## 1. Creación de la base de datos

Crea la base de datos usando los scripts de creación e inserción en la carpeta `src/db/`.

## 2. Conexión con la base de datos

Configura los datos de conexión en el archivo `src/config/db.php`.

## 3. Instalación de las librerías necesarias

En la raíz del proyecto, ejecuta los siguientes comandos para instalar los recursos necesarios.

```bash
composer require google/apiclient:"^2.0"
composer require league/oauth2-client
```

## 4. Ejecución

Ejecuta el siguiente comando para iniciar el servidor PHP:

```bash
php -S localhost:1111 -t src/public
```

## 5. Inicio de sesión

Regístrate o inicia sesión con Google/Microsoft para acceder al sistema.

---

> ¡Esos fueron todos los pasos!  
> _¡Disfruta de la aplicación web!_
