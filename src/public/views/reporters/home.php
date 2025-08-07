<h2>Incidencias reportadas</h2>
<div class="d-flex justify-content-end mb-3">
    <a id="btn-create" href="edit_incidence.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Crear
    </a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha de ocurrencia</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($incidents as $incident) {
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($incident['title']) ?></td>
                <td><?= htmlspecialchars($incident['incidence_description']) ?></td>
                <td><?= htmlspecialchars($incident['occurrence_date']) ?></td>
                <td><?= htmlspecialchars($incident['comments']) ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php if (!$incidents): ?>
    <div id="noData" class="no-data">
        <i class="bi bi-inbox-fill fs-1 mb-2"></i>
        <div>No se encontraron incidencias.</div>
    </div>
<?php endif; ?>