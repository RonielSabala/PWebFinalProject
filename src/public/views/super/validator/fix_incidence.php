<?php

use App\Utils\GeneralUtils;


function render_json_td(string $json_string): string
{
    $data = json_decode($json_string, true);
    $prettify_key = function ($k) {
        return ucwords(str_replace(['_', '-'], [' ', ' '], $k));
    };

    $html = '<div class="json-blob"><div class="card"><dl>';
    foreach ($data as $key => $value) {
        $html .= '<dt>' . htmlspecialchars($prettify_key($key)) . '</dt>';
        $html .= '<dd>';
        if (is_array($value)) {
            $is_assoc = array_keys($value) !== range(0, count($value) - 1);
            if ($is_assoc) {
                $html .= '<div class="mono small">' . htmlspecialchars(json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . '</div>';
            } else {
                foreach ($value as $item) {
                    if (is_array($item)) {
                        $html .= '<span class="badge">' . htmlspecialchars(json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) . '</span>';
                    } else {
                        $html .= '<span class="badge">' . htmlspecialchars((string)$item) . '</span>';
                    }
                }
            }
        } elseif (is_bool($value)) {
            $html .= '<span class="mono">' . ($value ? 'true' : 'false') . '</span>';
        } elseif (is_string($value) && preg_match('~^https?://~i', $value)) {
            $safe = htmlspecialchars($value);
            $html .= '<a href="' . $safe . '" target="_blank" rel="noopener noreferrer">Ver enlace</a>';
        } elseif (is_string($value) && mb_strlen($value) > 120) {
            $html .= '<div class="long small">' . nl2br(htmlspecialchars($value)) . '</div>';
        } elseif (is_int($value) || is_float($value)) {
            $html .= '<span class="mono">' . htmlspecialchars((string)$value) . '</span>';
        } else {
            $html .= htmlspecialchars((string)$value);
        }

        $html .= '</dd>';
    }

    $html .= '</dl></div></div>';
    return $html;
}
?>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="hero d-flex gap-3 align-items-center">
            <div class="icon-box rounded-3">
                <i class="bi bi-clipboard-check fs-3" style="color: var(--accent-2)"></i>
            </div>
            <div>
                <h2 class="mb-0">Corregir incidencias</h2>
                <p class="muted-sm mt-2 mb-0">
                    Revisa las solicitudes de corrección de incidencias y decide si aprobarlas o rechazarlas.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Hecha por</th>
                <th>Correcciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($corrections as $correction): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $correction['username'] ?></td>
                    <td><?= render_json_td($correction['correction_values']) ?></td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="/incidents/incidence.php?id=<?= $correction['id'] ?>" class="btn btn-sm btn-outline-action btn-go" title="Abrir en pantalla completa">
                                Ver original
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <a href="approve_correction.php?id=<?= $correction['id'] ?>" class="btn btn-success btn-sm">Aprobar</a>
                            <a href="reject_correction.php?id=<?= $correction['id'] ?>" class="btn btn-danger btn-sm">Rechazar</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= GeneralUtils::showNoData($corrections, "solicitudes de corrección"); ?>
</div>