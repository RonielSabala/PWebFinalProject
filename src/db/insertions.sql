-- Roles preestablecidos
INSERT INTO roles (role_name) VALUES
('default'),
('reportero'),
('validador'),
('admin');

-- Usuarios
INSERT INTO users (username, email, phone, password_hash) VALUES
('juan perez',    'juan.perez@example.com',    '809-555-0101',  'hash1'),
('maria gonzalez','maria.gonzalez@example.com','809-555-0202',  'hash2'),
('carlos rodrigz','carlo.rodriguez@example.com','809-555-0303',  'hash3');

-- Provincias
INSERT INTO provinces (province_name) VALUES
('Santo Domingo'),
('Santiago'),
('La Vega');

-- Municipios
INSERT INTO municipalities (municipality_name, province_id) VALUES
('Distrito Nacional', 1),  -- Santo Domingo
('Santiago de los Caballeros', 2),
('Concepción de La Vega',   3);

-- Barrios
INSERT INTO neighborhoods (neighborhood_name, municipality_id) VALUES
('Gazcue',             1),
('Centro Histórico',   2),
('El Ingenio',         3);

-- Incidencias
INSERT INTO incidents (
    title,
    incidence_description,
    occurrence_date,
    latitude,
    longitude,
    is_approved,
    n_deaths,
    n_injured,
    n_losses,
    province_id,
    municipality_id,
    neighborhood_id,
    group_hash,
    user_id
) VALUES
-- 1ª incidencia
(
    'Choque múltiple en Autopista Duarte',
    'Colisión entre 4 vehículos a la altura del kilómetro 12. Se reportan 2 fallecidos y 8 heridos de diversa consideración.',
    '2025-07-20 08:30:00',
    18.483923, -69.931212,
    1,
    2,
    8,
    25000.00,
    1,
    1,
    1,
    'grp01a2b3c4d5',
    1
),
-- 2ª incidencia
(
    'Inundación tras lluvias intensas',
    'Anegación de varias calles en el Centro Histórico. Daños materiales en viviendas y locales comerciales.',
    '2025-06-10 03:45:00',
    19.451111, -70.693889,
    0,
    0,
    3,
    42000.50,
    2,
    2,
    2,
    'grp06e7f8g9h0',
    2
),
-- 3ª incidencia
(
    'Protesta con disturbios',
    'Manifestación frente al Palacio de Justicia terminó en enfrentamientos con la policía. 1 fallecido y varios heridos.',
    '2025-07-28 19:15:00',
    19.230456, -70.528000,
    1,
    1,
    12,
    18000.00,
    3,
    3,
    3,
    'grp11i12j13k14',
    3
);

-- Etiquetas
INSERT INTO labels (label_name) VALUES
('Accidente de tráfico'),
('Desastre natural'),
('Protesta social');

-- Etiquetas de incidencias
INSERT INTO incidence_labels (incidence_id, label_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Comentarios
INSERT INTO comments (incidence_id, user_id, comment_text) VALUES
(1, 1, "Que peligrosa situación!"),
(2, 2, "Mi hijo estuvo ahí, muy fuerte situación!"),
(3, 3, "Espero los heridos se puedan recuperar!");