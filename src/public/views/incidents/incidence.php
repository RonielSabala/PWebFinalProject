<?php
// Datos
$title = $incidence['title'];
$description = $incidence['incidence_description'];
$occurrence = (new DateTime($incidence['occurrence_date']))->format('d/m/Y H:i');
$created = (new DateTime($incidence['creation_date']))->format('d/m/Y H:i');
$deaths = $incidence['n_deaths'];
$injured = $incidence['n_injured'];
$losses = number_format((float)($incidence['n_losses']), 2, ',', '.');

// Paleta de colores
$avatar_colors = [
    '#0f172a',
    '#1f2937',
    '#374151',
    '#4b5563',
    '#64748b',
    '#0b7285',
    '#1e40af',
    '#065f46',
    '#92400e',
    '#6d28d9'
];

function avatar_color($seed, $colors)
{
    $idx = crc32($seed) % count($colors);
    return $colors[$idx];
}

// Avatar del usuario actual
$current_user_initial = strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1));
$current_user_color = avatar_color($_SESSION['username'] ?? 'U', $avatar_colors);
?>

<div class="container-incident">
    <div class="card-min mb-4">
        <!-- Cabecera -->
        <div class="incident-header">
            <div>
                <h2 class="incident-title"><?= $title ?></h2>
                <div class="incident-meta">Publicado: <strong><?= $created ?></strong> · Ocurrencia: <strong><?= $occurrence ?></strong></div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="card-section">
            <!-- Descripción -->
            <div>
                <div class="section-title">Descripción</div>
                <div class="description-text"><?= $description ?></div>
            </div>

            <!-- Detalles -->
            <div style="margin-top:1rem;">
                <div class="section-title" style="margin-bottom:.4rem;">Detalles</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-pill pill-deaths">Muertos: <span style="margin-left:.6rem; font-weight:800; color:inherit;"><?= $deaths ?></span></div>
                        <div class="info-pill pill-injured">Heridos: <span style="margin-left:.6rem; font-weight:800; color:inherit;"><?= $injured ?></span></div>
                        <div class="info-pill pill-losses">Pérdidas: <span style="margin-left:.6rem; font-weight:800; color:inherit;">RD$ <?= $losses ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comentarios -->
    <div class="mb-3">
        <h5 style="margin-bottom:.35rem;">Comentarios <span class="small-muted">· <?= count($comments) ?></span></h5>

        <!-- Añadir comentario -->
        <div class="card card-section mb-3">
            <form method="POST" action="/incidents/<?= (int)$incidence['id'] ?>/comments" class="form-comment" autocomplete="off">
                <div style="display:flex; gap:12px; align-items:flex-start;">
                    <div class="comment-avatar" aria-hidden="true" style="background: <?= $current_user_color ?>;">
                        <?= $current_user_initial ?>
                    </div>
                    <div style="flex:1;">
                        <textarea name="comment_text" class="form-control" placeholder="Añade un comentario público..." required></textarea>
                        <div style="display:flex; justify-content:flex-end; margin-top:.5rem;">
                            <button type="submit" class="btn btn-primary btn-sm">Comentar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de comentarios -->
        <div class="card card-section">
            <?php if (empty($comments)): ?>
                <div class="py-4 text-center small-muted">Aún no hay comentarios. Sé el primero en comentar.</div>
            <?php else: ?>
                <?php foreach ($comments as $c):
                    $author = htmlspecialchars($c['username'] ?? 'Usuario');
                    $cdate = isset($c['creation_date']) ? (new DateTime($c['creation_date']))->format('d/m/Y H:i') : '';
                    $ctext = nl2br(htmlspecialchars($c['comment_text'] ?? ''));
                    $initial = strtoupper(substr($author, 0, 1));
                    $acolor = avatar_color($author, $avatar_colors);
                ?>
                    <div class="comment-row" role="article">
                        <div class="comment-avatar" style="background: <?= $acolor ?>;" aria-hidden="true"><?= $initial ?></div>
                        <div class="comment-body">
                            <div style="display:flex; align-items:center; gap:.6rem;">
                                <div class="comment-author"><?= $author ?></div>
                                <div class="comment-meta"><?= $cdate ?></div>
                            </div>
                            <div class="comment-text"><?= $ctext ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>