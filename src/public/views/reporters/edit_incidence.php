<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Datos de la incidencia</h4>
        </div>
        <div class="card-body">
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="5" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de ocurrencia</label>
                    <input type="datetime-local" name="ocurrence_date" class="form-control" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Latitud</label>
                        <input type="text" name="lat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Longitud</label>
                        <input type="text" name="lng" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Muertos</label>
                        <input type="number" name="cant_muertos" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Heridos</label>
                        <input type="number" name="cant_heridos" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pérdidas RD$</label>
                        <input type="number" name="cant_perdidas" step="0.01" min="0" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <select id="provincia" name="provincia_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($provinces as $prov) {
                            echo "<option value='{$prov['id']}'>{$prov['province_name']}</option>";
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Municipio</label>
                    <select name="municipio_id" id="municipio" class="form-select" required>
                        <option value="">Seleccione provincia primero</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Barrio</label>
                    <select name="barrio_id" id="barrio" class="form-select" required>
                        <option value="">Seleccione municipio primero</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto URL</label>
                    <input type="text" name="foto" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Etiquetas</label><br>
                    <?php foreach ($labels as $label) {
                        echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='checkbox' name='etiquetas[]' value='{$label['id']}'>
                                    <label class='form-check-label'>{$label['nombre']}</label>
                                  </div>";
                    } ?>
                </div>

                <input type="hidden" name="usuario_id" value="1">
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Guardar incidencia</button>
                    <a href="/incidents/map.php" class="btn btn-outline-primary">Ver Mapa</a>
                </div>
            </form>
        </div>
    </div>
</div>