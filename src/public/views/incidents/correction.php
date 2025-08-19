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
                        <input id="coordinates" class="form-control" name="coordinates"
                            type="text" required value="<?= htmlspecialchars($coordinates) ?>">
                        <div class="invalid-feedback">Formato inválido. Usa: latitud, longitud (ej: 18.7357, -70.1627)</div>

                    </div>
                </div>

                <!-- Impacto -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-graph-up me-2"></i>Impacto
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="n_deaths" class="form-label">Fallecidos</label>
                            <input id="n_deaths" class="form-control" name="n_deaths"
                                type="number" min="0" value="<?= $incidence['n_deaths'] ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="n_injured" class="form-label">Heridos</label>
                            <input id="n_injured" class="form-control" name="n_injured"
                                type="number" min="0" value="<?= $incidence['n_injured'] ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="n_losses" class="form-label">Pérdidas (RD$)</label>
                            <input id="n_losses" class="form-control" name="n_losses"
                                type="number" step="0.01" min="0" value="<?= $incidence['n_losses'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Ubicación Administrativa -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-building me-2"></i>Ubicación Administrativa
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="province" class="form-label">Provincia</label>
                            <select id="province" class="form-select" name="province_id" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province['id'] ?>"
                                        <?= $province['id'] == $incidence['province_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($province['province_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="municipality" class="form-label">Municipio</label>
                            <select id="municipality" class="form-select" name="municipality_id">
                                <?php foreach ($municipalities as $municipality): ?>
                                    <option value="<?= $municipality['id'] ?>"
                                        <?= $municipality['id'] == $incidence['municipality_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($municipality['municipality_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="neighborhood" class="form-label">Barrio</label>
                            <select id="neighborhood" class="form-select" name="neighborhood_id">
                                <?php foreach ($neighborhoods as $neighborhood): ?>
                                    <option value="<?= $neighborhood['id'] ?>"
                                        <?= $neighborhood['id'] == $incidence['neighborhood_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($neighborhood['neighborhood_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                </div>
            </form>
        </div>
    </div>
</div>