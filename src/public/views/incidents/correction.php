<div class="container">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h3 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Sugerir corrección para: <?= htmlspecialchars($incidence['title']) ?>
            </h3>
        </div>

        <div class="card-body px-4 py-4">
            <form id="correctionForm" method="post">
                <input type="hidden" name="incidence_id" value="<?= $incidence['id'] ?>">

                <!-- Ubicación -->
                <div class="mb-4 mt-3">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-geo-alt-fill me-2"></i>Ubicación
                    </h5>
                    <!-- Coordenadas -->
                    <div class="">
                        <label for="coordinates" class="form-label">Coordenadas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo"></i></span>
                            <input id="coordinates" class="form-control" name="coordinates" type="text" required value="<?= htmlspecialchars($coordinates) ?>">
                        </div>
                        <div class="invalid-feedback">Formato inválido. Usa: latitud, longitud (ej: 18.7357, -70.1627)</div>

                    </div>
                </div>

                <!-- Impacto -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-graph-up me-2"></i>Impacto de la Incidencia</h5>
                    <div class="row g-3">

                        <!-- Fallecidos -->
                        <div class="col-md-4">
                            <label for="n_deaths" class="form-label">Fallecidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-emoji-dizzy"></i></span>
                                <input id="n_deaths" value="<?= htmlspecialchars($incidence['n_deaths'] ?? 0) ?>" class="form-control" name="n_deaths" type="number" min="0" placeholder="0">
                            </div>
                        </div>
                        <!-- Heridos -->
                        <div class="col-md-4">
                            <label for="n_injured" class="form-label">Heridos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-emoji-frown"></i></span>
                                <input id="n_injured" value="<?= htmlspecialchars($incidence['n_injured'] ?? 0) ?>" class="form-control" name="n_injured" type="number" min="0" placeholder="0">
                            </div>
                        </div>
                        <!-- Pérdidas económicas -->
                        <div class="col-md-4">
                            <label for="n_losses" class="form-label">Pérdidas económicas (RD$)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                                <input id="n_losses" value="<?= htmlspecialchars($incidence['n_losses'] ?? 0) ?>" class="form-control" name="n_losses" type="number" step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Ubicación Administrativa -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-building me-2"></i>Ubicación Administrativa</h5>
                    <div class="row g-3">
                        <!-- Provincia -->
                        <div class="col-md-4">
                            <label for="province" class="form-label">Provincia</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <select id="province" class="form-select" name="province_id" data-editing-province="<?php echo $incidence->province_id ?? ''; ?>" required>
                                    <option selected value="">Seleccione</option>
                                    <?php foreach ($provinces as $prov): ?>
                                        <option value="<?= $prov['id'] ?>" <?= (isset($incidence['province_id']) && $incidence['province_id'] === $prov['id']) ? 'selected' : '' ?>><?= $prov['province_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Municipio -->
                        <div class="col-md-4">
                            <label for="municipality" class="form-label">Municipio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-map"></i></span>
                                <select id="municipality" data-editing-municipality="<?php echo $incidence['municipality_id'] ?? ''; ?>" class="form-select" name="municipality_id" <?= empty($incidence['province_id']) ? 'disabled' : '' ?>>
                                    <?php if (!empty($incidence['municipality_id']) && !empty($municipality_name)): ?>
                                        <option value="<?= htmlspecialchars($incidence['municipality_id']) ?>" selected>
                                            <?= ($incidence['municipality_id'] ?? '') ? 'selected' : '' ?>>
                                        </option>
                                    <?php else: ?>
                                        <option value="" selected disabled>Seleccione un municipio</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Barrio -->
                        <div class="col-md-4">
                            <label for="neighborhood" class="form-label">Barrio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-house"></i></span>
                                <select id="neighborhood" class="form-select" name="neighborhood_id" data-editing-neighborhood="<?php echo $incidence['neighborhood_id'] ?? ''; ?>" <?= empty($incidence['municipality_id']) ? 'disabled' : '' ?>>
                                    <?php if (!empty($incidence['neighborhood_id']) && !empty($neighborhood_name)): ?>
                                        <option value="<?= htmlspecialchars($incidence['neighborhood_id']) ?>" selected>

                                        </option>
                                    <?php else: ?>
                                        <option value="" selected disabled>Seleccione un barrio</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between mt-4">
                    <!-- Botón guardar -->
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-medium">
                        <i class="bi bi-send-fill me-2"></i> Enviar corrección
                    </button>

                    <!-- Botón cancelar -->
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium" onclick="history.back()">
                        <i class="bi bi-arrow-left-circle-fill me-2"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>