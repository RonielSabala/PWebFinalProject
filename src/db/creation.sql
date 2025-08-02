DROP DATABASE IF EXISTS incidents_db;
CREATE DATABASE incidents_db;
USE incidents_db;

-- Usuarios
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id            INT          PRIMARY KEY AUTO_INCREMENT,
    username      VARCHAR(50)  NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    phone         VARCHAR(15)  NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    creation_date DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Roles
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id        INT PRIMARY KEY AUTO_INCREMENT,
    role_name ENUM('default','reportero','validador','admin') NOT NULL
);

-- Relación m:n Usuarios–Roles
DROP TABLE IF EXISTS user_roles;
CREATE TABLE user_roles (
    user_id  INT NOT NULL,
    role_id  INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Provincias
DROP TABLE IF EXISTS provinces;
CREATE TABLE provinces (
    id            TINYINT     PRIMARY KEY AUTO_INCREMENT,
    province_name VARCHAR(35) NOT NULL UNIQUE
);

-- Municipios
DROP TABLE IF EXISTS municipalities;
CREATE TABLE municipalities (
    id                SMALLINT     PRIMARY KEY AUTO_INCREMENT,
    municipality_name VARCHAR(100) NOT NULL UNIQUE,
    province_id       TINYINT      NOT NULL,
    FOREIGN KEY (province_id) REFERENCES provinces(id) ON DELETE CASCADE
);

-- Barrios
DROP TABLE IF EXISTS neighborhoods;
CREATE TABLE neighborhoods (
    id                SMALLINT     PRIMARY KEY AUTO_INCREMENT,
    neighborhood_name VARCHAR(100) NOT NULL,
    municipality_id   SMALLINT     NOT NULL,
    UNIQUE (neighborhood_name, municipality_id),
    FOREIGN KEY (municipality_id) REFERENCES municipalities(id) ON DELETE CASCADE
);

-- Incidencias
DROP TABLE IF EXISTS incidents;
CREATE TABLE incidents (
    id                    INT           PRIMARY KEY AUTO_INCREMENT,
    title                 VARCHAR(200)  NOT NULL,
    incidence_description TEXT          NOT NULL,
    occurrence_date       DATETIME      NOT NULL,
    latitude              DOUBLE        NOT NULL,
    longitude             DOUBLE        NOT NULL,
    is_approved           TINYINT(1)    NOT NULL DEFAULT 0,
    n_deaths              INT           DEFAULT 0,
    n_injured             INT           DEFAULT 0,
    n_losses              DECIMAL(15,2) DEFAULT 0,
    province_id           TINYINT       NOT NULL,
    municipality_id       SMALLINT,
    neighborhood_id       SMALLINT,
    group_hash            VARCHAR(255),
    user_id               INT           NOT NULL,
    creation_date         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (province_id)     REFERENCES provinces(id)      ON DELETE CASCADE,
    FOREIGN KEY (municipality_id) REFERENCES municipalities(id) ON DELETE SET NULL,
    FOREIGN KEY (neighborhood_id) REFERENCES neighborhoods(id)  ON DELETE SET NULL,
    FOREIGN KEY (user_id)         REFERENCES users(id)          ON DELETE CASCADE
);

-- Fotos de incidencias
DROP TABLE IF EXISTS photos;
CREATE TABLE photos (
    id           INT          PRIMARY KEY AUTO_INCREMENT,
    incidence_id INT          NOT NULL,
    photo_url    VARCHAR(500) NOT NULL,
    FOREIGN KEY (incidence_id) REFERENCES incidents(id) ON DELETE CASCADE
);

-- Etiquetas de incidencias
DROP TABLE IF EXISTS labels;
CREATE TABLE labels (
    id         INT         PRIMARY KEY AUTO_INCREMENT,
    label_name VARCHAR(45) NOT NULL UNIQUE
);

-- Relación m:n Incidencias-Etiquetas
DROP TABLE IF EXISTS incidence_labels;
CREATE TABLE incidence_labels (
    incidence_id INT NOT NULL,
    label_id     INT NOT NULL,
    PRIMARY KEY (incidence_id, label_id),
    FOREIGN KEY (incidence_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (label_id)     REFERENCES labels(id)    ON DELETE CASCADE
);

-- Comentarios
DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    id            INT      PRIMARY KEY AUTO_INCREMENT,
    incidence_id  INT      NOT NULL,
    user_id       INT      NOT NULL,
    comment_text  TEXT     NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidence_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)      REFERENCES users(id)     ON DELETE CASCADE
);

-- Correcciones
DROP TABLE IF EXISTS corrections;
CREATE TABLE corrections (
    id                INT        PRIMARY KEY AUTO_INCREMENT,
    incidence_id      INT        NOT NULL,
    user_id           INT        NOT NULL,
    correction_values JSON       NOT NULL,
    is_approved       TINYINT(1) NOT NULL DEFAULT 0,
    creation_date     DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidence_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)      REFERENCES users(id)     ON DELETE CASCADE
);
