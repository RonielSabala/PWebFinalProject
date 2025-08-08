<p><strong>Título:</strong> <?= $incidence['title'] ?></p>
<p><strong>Descripción:</strong> <?= $incidence['incidence_description'] ?></p>
<p><strong>Fecha y Hora:</strong> <?= $incidence['occurrence_date'] ?></p>
<p><strong>Muertos:</strong> <?= $incidence['n_deaths'] ?></p>
<p><strong>Heridos:</strong> <?= $incidence['n_injured'] ?></p>
<p><strong>Pérdidas:</strong> RD$<?= $incidence['n_losses'] ?></p>
<hr>
<p class="text-center"><strong>Comentarios</strong></p>
<div id="modalComments">
    <?php
    if (empty($comments)) {
    ?>
        <p>No hay comentarios...</p>
    <?php
    } else {
        foreach ($comments as $c) {
            echo "<p><strong>{$c['creation_date']}</strong> {$c['username']}: {$c['comment_text']}</p>";
        }
    }
    ?>
</div>