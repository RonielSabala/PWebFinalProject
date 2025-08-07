<div class="container mt-2">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Datos de la incidencia</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <!-- Título -->
                <div class="mb-3">
                    <label class="form-label" for="title">Título</label>
                    <input id="title" class="form-control" name="title" type="text" required>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label class="form-label" for="incidence_description">Descripción</label>
                    <textarea id="incidence_description" class="form-control" name="incidence_description" rows="5" required></textarea>
                </div>

                <!-- Fecha -->
                <div class="mb-3">
                    <label class="form-label" for="occurrence_date">Fecha de ocurrencia</label>
                    <input id="occurrence_date" class="form-control" name="occurrence_date" type="datetime-local" required>
                </div>

                <!-- Coordenadas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="latitude">Latitud</label>
                        <input id="latitude" class="form-control" name="latitude" type="text" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="longitude">Longitud</label>
                        <input id="longitude" class="form-control" name="longitude" type="text" required>
                    </div>
                </div>

                <!-- Perdidas -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label" for="n_deaths">Muertos</label>
                        <input id="n_deaths" class="form-control" name="n_deaths" type="number" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="n_injured">Heridos</label>
                        <input id="n_injured" class="form-control" name="n_injured" type="number" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="n_losses">Pérdidas RD$</label>
                        <input id="n_losses" class="form-control" name="n_losses" type="number" step="0.01" min="0">
                    </div>
                </div>

                <!-- Provincia -->
                <div class="mb-3">
                    <label class="form-label" for="province">Provincia</label>
                    <select id="province" class="form-select" name="province_id" required>
                        <option selected value="">Seleccione</option>
                        <?php foreach ($provinces as $prov): ?>
                            <option value="<?= $prov['id'] ?>"><?= $prov['province_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Municipio -->
                <div class="mb-3">
                    <label class="form-label" for="municipality">Municipio</label>
                    <select id="municipality" class="form-select" name="municipality_id">
                    </select>
                </div>

                <!-- Barrio -->
                <div class="mb-3">
                    <label class="form-label" for="neighborhood">Barrio</label>
                    <select id="neighborhood" class="form-select" name="neighborhood_id">
                    </select>
                </div>

                <!-- Foto -->
                <div class="mb-3">
                    <label class="form-label" for="photo">Foto URL</label>
                    <input id="photo" class="form-control" name="photo_url" type="text">
                </div>

                <!-- Etiquetas -->
                <div class="mb-3">
                    <label class="form-label">Etiquetas</label><br>
                    <?php foreach ($labels as $label) {
                        $id = $label['id'];
                        $name = $label['label_name'];
                        echo "
                        <div class='form-check'>
                            <input id='Label{$id}' class='form-check-input' name='labels[]' type='checkbox' value='{$id}'>
                            <label class='form-check-label' for='Label{$id}'>{$name}</label>
                        </div>
                        ";
                    } ?>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Guardar incidencia</button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="home.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>