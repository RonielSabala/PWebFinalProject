<div class="centered container">
    <!-- Buscador principal -->
    <div id="search-bar-container">
        <div class="search-bar">
            <input type="text" id="titleFilter" class="form-control" placeholder="Buscar por título…" />
            <select id="provinceFilter" class="form-select">
                <option value="">Todas</option>
                <?php foreach ($provinces as $prov): ?>
                    <option value="<?= $prov['id'] ?>"><?= $prov['province_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" id="fromFilter" class="form-control" />
            <input type="date" id="toFilter" class="form-control" />
            <button id="searchButton" class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="results-row d-flex justify-content-between align-items-center my-3">
            <!-- Contador de resultados -->
            <div id="resultsCount">Cargando...</div>

            <!-- Botón para alternar entre mapa y lista -->
            <div class="d-flex justify-content-between align-items-center">
                <?= $button ?>
            </div>

            <!-- Botón para alternar limite inferior para las fechas -->
            <div class="d-flex align-items-center ms-3">
                <div class="form-check form-switch custom-switch align-items-center">
                    <input class="form-check-input" type="checkbox" id="beautifulToggle" checked aria-checked="true" />
                    <label class="form-check-label ms-2" for="beautifulToggle" id="toggleLabel">
                        Últimas 24h
                        <span id="beautifulToggleState" aria-hidden="true" class="badge-state">ON</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Incidents view here -->