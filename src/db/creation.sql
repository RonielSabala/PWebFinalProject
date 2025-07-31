DROP DATABASE IF EXISTS incidencias_db;
CREATE DATABASE incidencias_db;
USE incidencias_db;

-- Usuarios
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id               INT             PRIMARY KEY AUTO_INCREMENT,
    nombre           VARCHAR(50)     NOT NULL,
    email            VARCHAR(100)    NOT NULL UNIQUE,
    telefono         VARCHAR(15)     NOT NULL,
    password_hash    VARCHAR(255)    NOT NULL,
    fecha_creacion   DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Roles
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id     INT    PRIMARY KEY AUTO_INCREMENT,
    nombre ENUM('default','reportero','validador','admin') NOT NULL
);

-- Relación Usuario–Rol
DROP TABLE IF EXISTS roles_usuarios;
CREATE TABLE roles_usuarios (
    roles_id     INT NOT NULL,
    usuarios_id  INT NOT NULL,
    PRIMARY KEY (usuarios_id, roles_id),
    FOREIGN KEY (usuarios_id)  REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (roles_id)     REFERENCES roles(id)    ON DELETE CASCADE
);

-- Provincias
DROP TABLE IF EXISTS provincias;
CREATE TABLE provincias (
    id     TINYINT       PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(35)   NOT NULL UNIQUE
);

-- Municipios
DROP TABLE IF EXISTS municipios;
CREATE TABLE municipios (
    id            SMALLINT     PRIMARY KEY AUTO_INCREMENT,
    nombre        VARCHAR(100) NOT NULL UNIQUE,
    provincia_id  TINYINT      NOT NULL,
    FOREIGN KEY (provincia_id) REFERENCES provincias(id) ON DELETE CASCADE
);

-- Barrios
DROP TABLE IF EXISTS barrios;
CREATE TABLE barrios (
    id           MEDIUMINT     PRIMARY KEY AUTO_INCREMENT,
    nombre       VARCHAR(100)  NOT NULL,
    municipio_id SMALLINT      NOT NULL,
    FOREIGN KEY (municipio_id) REFERENCES municipios(id) ON DELETE CASCADE,
    UNIQUE (nombre, municipio_id)
);

-- Incidencias
DROP TABLE IF EXISTS incidencias;
CREATE TABLE incidencias (
    id               INT             PRIMARY KEY AUTO_INCREMENT,
    titulo           VARCHAR(200)    NOT NULL,
    descripcion      TEXT            NOT NULL,
    fecha_ocurrencia DATETIME        NOT NULL,
    latitud          DOUBLE          NULL,
    longitud         DOUBLE          NULL,
    esta_aprobada    TINYINT(1)      NOT NULL DEFAULT 0,
    muertos          INT             DEFAULT 0,
    heridos          INT             DEFAULT 0,
    perdidas_usd     DECIMAL(15,2)   DEFAULT 0,
    provincia_id     TINYINT         NOT NULL,
    municipio_id     SMALLINT        NOT NULL,
    barrio_id        MEDIUMINT       NOT NULL,
    usuario_id       INT             NULL,
    fecha_creacion   DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (provincia_id)  REFERENCES provincias(id)  ON DELETE CASCADE,
    FOREIGN KEY (municipio_id)  REFERENCES municipios(id)  ON DELETE CASCADE,
    FOREIGN KEY (barrio_id)     REFERENCES barrios(id)     ON DELETE CASCADE,
    FOREIGN KEY (usuario_id)    REFERENCES usuarios(id)    ON DELETE SET NULL
);

-- Etiquetas de incidencias
DROP TABLE IF EXISTS etiquetas;
CREATE TABLE etiquetas (
    id     INT          PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(45)  NOT NULL UNIQUE
);

-- Relación Incidencias-Etiquetas
DROP TABLE IF EXISTS incidencias_etiquetas;
CREATE TABLE incidencias_etiquetas (
    incidencia_id INT NOT NULL,
    etiqueta_id   INT NOT NULL,
    PRIMARY KEY (incidencia_id, etiqueta_id),
    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id) ON DELETE CASCADE,
    FOREIGN KEY (etiqueta_id)   REFERENCES etiquetas(id)   ON DELETE CASCADE
);

-- Fotos de incidencias
DROP TABLE IF EXISTS fotos;
CREATE TABLE fotos (
    id            INT           PRIMARY KEY AUTO_INCREMENT,
    incidencia_id INT           NOT NULL,
    url           VARCHAR(500)  NOT NULL,
    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id) ON DELETE CASCADE
);

-- Comentarios
DROP TABLE IF EXISTS comentarios;
CREATE TABLE comentarios (
    id             INT           PRIMARY KEY AUTO_INCREMENT,
    incidencia_id  INT           NOT NULL,
    usuario_id     INT           NULL,
    texto          TEXT          NOT NULL,
    fecha_creacion DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidencia_id)  REFERENCES incidencias(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id)     REFERENCES usuarios(id)    ON DELETE SET NULL
);

-- Correcciones
DROP TABLE IF EXISTS correcciones;
CREATE TABLE correcciones (
    id             INT           PRIMARY KEY AUTO_INCREMENT,
    incidencia_id  INT           NOT NULL,
    usuario_id     INT           NULL,
    valores        JSON          NOT NULL,
    esta_aprobada  TINYINT(1)    NOT NULL DEFAULT 0,
    fecha_creacion DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidencia_id)  REFERENCES incidencias(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id)     REFERENCES usuarios(id)    ON DELETE SET NULL
);
