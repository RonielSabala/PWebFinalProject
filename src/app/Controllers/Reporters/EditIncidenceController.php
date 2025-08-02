<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\ProvinceUtils;
use App\Utils\LabelUtils;


class EditIncidenceController
{
    public function handle(Template $template)
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Guardamos datos
            $lat = floatval($_POST['lat']);
            $lng = floatval($_POST['lng']);
            $titulo = $pdo->real_escape_string($_POST['titulo']);
            $descripcion = $pdo->real_escape_string($_POST['descripcion']);
            $fecha_ocurrencia = $_POST['fecha_ocurrencia'];
            $muertos = intval($_POST['cant_muertos'] ?? 0);
            $heridos = intval($_POST['cant_heridos'] ?? 0);
            $perdidas = floatval($_POST['cant_perdidas'] ?? 0.0);
            $provincia_id = intval($_POST['provincia_id']);
            $municipio_id = intval($_POST['municipio_id']);
            $barrio_id = intval($_POST['barrio_id']);
            $foto_url = $pdo->real_escape_string($_POST['foto_url'] ?? '');
            $usuario_id = intval($_POST['usuario_id']);

            // Insertar en incidencias
            $sql = "INSERT INTO incidencias 
            (titulo, descripcion, fecha_ocurrencia, coordenadas, cant_muertos, cant_heridos, cant_perdidas, provincias_id, municipios_id, barrios_id, usuarios_id)
            VALUES 
            ('$titulo', '$descripcion', '$fecha_ocurrencia',  ST_GeomFromText('POINT($lng $lat)'), $muertos, $heridos, $perdidas, $provincia_id, $municipio_id, $barrio_id, 1)";

            if ($pdo->query($sql)) {
                $incidencia_id = $pdo->insert_id;

                // Insertar etiquetas
                if (!empty($_POST['etiquetas'])) {
                    foreach ($_POST['etiquetas'] as $etiqueta_id) {
                        $etiqueta_id = intval($etiqueta_id);
                        $pdo->query("INSERT INTO incidencias_etiquetas (incidencias_id, etiquetas_id) VALUES ($incidencia_id, $etiqueta_id)");
                    }
                }

                //Insertar Imagenes
                if (!empty($foto_url)) {
                    $pdo->query("INSERT INTO fotos (url, incidencias_id) VALUES ('$foto_url', $incidencia_id)");
                }

                echo "<p> Incidencia guardada correctamente.</p>";
            } else {
                echo "<p> Error al guardar: " . $pdo->error . "</p>";
            }
        }

        $template->apply([
            'provinces' => ProvinceUtils::getAll(),
            'labels' => LabelUtils::getAll(),
        ]);
    }
}
