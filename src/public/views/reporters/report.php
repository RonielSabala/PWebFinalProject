<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h3 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i> Reportar Nueva Incidencia</h3>
        </div>
        <div class="card-body px-4 py-4">
            <form id="incidenceForm" method="post">
                <!-- Información Básica -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Información Básica</h5>
                    <div class="row g-3">
                        <!-- Título -->
                        <div class="col-md-12">
                            <label for="title" class="form-label">Título</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                <input id="title" class="form-control" name="title" type="text" required placeholder="Ej: Inundación en el sector Los Prados">
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-12">
                            <label for="incidence_description" class="form-label">Descripción detallada</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
                                <textarea id="incidence_description" class="form-control" name="incidence_description" rows="4" required placeholder="Describa la incidencia con el mayor detalle"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fecha y Ubicación -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Ubicación y Fecha</h5>
                    <div class="row g-3">
                        <!-- Fecha -->
                        <div class="col-md-6">
                            <label for="occurrence_date" class="form-label">Fecha y hora de ocurrencia</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input id="occurrence_date" class="form-control" name="occurrence_date" type="datetime-local" required>
                            </div>
                        </div>

                        <!-- Coordenadas -->
                        <div class="col-md-6">
                            <label for="coordinates" class="form-label">Coordenadas (lat, lng)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                <input id="coordinates" class="form-control" name="coordinates" type="text" required placeholder="Ej: 18.7357, -70.1627">
                                <div class="invalid-feedback">Formato inválido. Usa: latitud, longitud (ej: 18.7357, -70.1627)</div>
                            </div>
                            <small class="text-muted">Formato: latitud, longitud (ej: 18.7357, -70.1627)</small>
                        </div>
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
                                <input id="n_deaths" class="form-control" name="n_deaths" type="number" min="0" placeholder="0">
                            </div>
                        </div>
                        <!-- Heridos -->
                        <div class="col-md-4">
                            <label for="n_injured" class="form-label">Heridos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-emoji-frown"></i></span>
                                <input id="n_injured" class="form-control" name="n_injured" type="number" min="0" placeholder="0">
                            </div>
                        </div>
                        <!-- Pérdidas económicas -->
                        <div class="col-md-4">
                            <label for="n_losses" class="form-label">Pérdidas económicas (RD$)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                                <input id="n_losses" class="form-control" name="n_losses" type="number" step="0.01" min="0" placeholder="0.00">
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
                                <select id="province" class="form-select" name="province_id" required>
                                    <option selected value="">Seleccione</option>
                                    <?php foreach ($provinces as $prov): ?>
                                        <option value="<?= $prov['id'] ?>"><?= $prov['province_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Municipio -->
                        <div class="col-md-4">
                            <label for="municipality" class="form-label">Municipio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-map"></i></span>
                                <select id="municipality" class="form-select" name="municipality_id" disabled>

                                </select>
                            </div>
                        </div>

                        <!-- Barrio -->
                        <div class="col-md-4">
                            <label for="neighborhood" class="form-label">Barrio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-house"></i></span>
                                <select id="neighborhood" class="form-select" name="neighborhood_id" disabled>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Multimedia y Etiquetas -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-tags-fill me-2"></i>Clasificación</h5>

                    <!-- Foto -->
                    <div class="mb-4">
                        <label for="photo" class="form-label">Imagen de referencia (URL)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input id="photo" class="form-control" name="photo_url" type="url" placeholder="https://ejemplo.com/imagen.jpg">
                            <div class="invalid-feedback">Por favor ingrese una URL válida.</div>
                        </div>
                        <small class="text-muted">Puede subir la imagen a un servicio como Imgur y pegar el enlace aquí</small>
                    </div>

                    <!-- Etiquetas -->
                    <div>
                        <label class="form-label">Etiquetas</label>
                        <div class="tag-container p-3 border rounded">
                            <div class="row">
                                <?php foreach ($labels as $label): ?>
                                    <div class="col-4 mb-2">
                                        <div class="form-check">
                                            <input id="Label<?= $label['id'] ?>" class="form-check-input" name="labels[]" type="checkbox" value="<?= $label['id'] ?>">
                                            <label class="form-check-label" for="Label<?= $label['id'] ?>"><?= $label['label_name'] ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-between mt-4">
                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-medium">
                            <i class="bi bi-save-fill me-2"></i> Guardar Incidencia
                        </button>

                        <!-- Botón Cancelar -->
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium" onclick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill me-2"></i> Cancelar
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>