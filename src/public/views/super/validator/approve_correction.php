<?php

use App\Utils\PrintUtils;
?>

<div class="container center-screen pt-2">
    <div class="card shadow-sm entity-card w-100">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Aprobar corrección</h3>
        </div>
        <div class="card-body">
            <div class="approve-warning">
                <h5>
                    <i class="bi bi-check2-circle me-2"></i>
                    ¿Estás seguro de que quieres aprobar esta <strong>corrección</strong>?
                </h5>
            </div>

            <form method="post">
                <dl class="row">
                    <div class="fields-grid">
                        <div class="field-item">
                            <label for="incidence" class="field-label">Incidencia original</label>
                            <div id="incidence" name="incidence" class="field-value">
                                <a href="/incidents/incidence.php?id=<?= $correction['incidence_id'] ?>" class="btn btn-sm btn-outline-action btn-go">
                                    Ver
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="field-item">
                            <label for="date" class="field-label">Fecha de solicitud</label>
                            <div id="date" name="date" class="field-value">
                                <?= PrintUtils::getPrintableDate($correction['creation_date']) ?>
                            </div>
                        </div>
                        <div class="field-item">
                            <label for="corrections" class="field-label">Correcciones</label>
                            <div id="corrections" name="corrections" class="field-value">
                                <?php
                                $data = json_decode($correction['correction_values'], true);

                                // Mostrar cada campo por separado
                                echo '<div class="json-fields">';
                                foreach ($data as $key => $value) {
                                    echo '<div class="json-field mb-2">';
                                    echo '<label class="fw-bold">' . htmlspecialchars((string)$key) . '</label>';
                                    echo '<div class="ms-2">';
                                    if (is_null($value) || is_scalar($value)) {
                                        echo '<span>' . htmlspecialchars((string)$value) . '</span>';
                                    } else {
                                        // Para valores complejos (arrays u objetos), mostrar JSON bonito dentro de <pre>
                                        echo '<pre class="json-pre">' . htmlspecialchars(json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . '</pre>';
                                    }
                                    echo '</div></div>';
                                }
                                echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </dl>

                <div class="d-flex justify-content-between align-items-center mt-4 action-buttons">
                    <button type="submit" id="btn-approve" class="btn btn-lg btn-success">
                        <i class="bi bi-check-lg me-2"></i> Aprobar
                    </button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="correction_validation.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>