<?php

use App\Utils\GeneralUtils;


function render_json(string $json_string): string
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
                <th>Incidencia</th>
                <th>Corrector</th>
                <th>Fecha</th>
                <th>Correcciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($corrections as $correction): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <a href="/incidents/incidence.php?id=<?= $correction['incidence_id'] ?>" class="btn btn-sm btn-outline-action btn-go">
                            Ver
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                    <td>
                        <?= $correction['username'] ?>
                    </td>
                    <td>
                        <?= GeneralUtils::formatDate($correction['creation_date']) ?>
                    </td>
                    <td><?= GeneralUtils::render_json($correction['correction_values']) ?></td>
                    <td>
                        <a
                            href="approve_correction.php?id=<?= $correction['id'] ?>"
                            class="btn-modern btn-approve btn-sm"
                            title="Aprobar">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Aprobar</span>
                        </a>
                        <a
                            href="reject_correction.php?id=<?= $correction['id'] ?>"
                            class="btn-modern btn-reject btn-sm"
                            title="Rechazar">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Rechazar</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= GeneralUtils::showNoData($corrections, "solicitudes de corrección"); ?>
</div>