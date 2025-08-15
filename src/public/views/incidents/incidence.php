<?php

use App\Utils\Entities\UserUtils;
use App\Utils\Entities\IncidenceUtils;

// Datos
$incidenceId = $incidence['id'];
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

function avatar_color_index($seed, $colors)
{
    return crc32($seed) % count($colors);
}

function avatar_color($seed, $colors)
{
    $idx = avatar_color_index($seed, $colors);
    return $colors[$idx];
}

// Avatar del usuario actual
$user = $_SESSION['user'];
$user_id = $user['id'];
$username = $user['username'];
$is_super = UserUtils::isUserSuper($user_id);
$current_user_initial = strtoupper(substr($username, 0, 1));
$current_user_color_idx = avatar_color_index($username, $avatar_colors);
?>

<div class="container-incidence">
    <div class="card-min mb-4">
        <!-- Cabecera -->
        <div class="incidence-header">
            <div class="incidence-card">
                <div class="incidence-main">
                    <div class="incidence-top">
                        <span class="kicker">NOTICIA</span>
                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16" focusable="false">
                            <path d="M12 2l2.1 4.6L19 8l-3.6 2.8L16 16l-4-2.5L8 16l.6-5.2L5 8l4.9-1.4L12 2z" />
                        </svg>
                    </div>

                    <h2 id="incidence-title" class="title"><?= htmlspecialchars($title) ?></h2>
                    <p class="incidence-meta" aria-label="Metadatos de la noticia">
                        <time datetime="<?= date('c', strtotime($created)) ?>">Publicado: <strong><?= $created ?></strong></time>
                        <span class="dot">·</span>
                        <span>Ocurrencia: <strong><?= $occurrence ?></strong></span>
                        <span class="dot">·</span>
                        <span>Reportaje por: <strong><?= htmlspecialchars($incidence['reporter_name']) ?></strong></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="card-section">
            <!-- Descripción -->
            <div class="section-description">
                <div id="desc-title" class="section-title">Descripción</div>
                <div class="description-text">
                    <?= IncidenceUtils::getPrettyDescription($description) ?>
                </div>
                <div class="sr-only" aria-hidden="false">Enlaces en azul; cada enlace aparece en una línea separada.</div>
            </div>

            <!-- Detalles -->
            <div class="mt-1rem">
                <div class="section-title section-title-small">Detalles</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-pill pill-deaths">Muertos: <span class="info-pill-value"><?= $deaths ?></span></div>
                        <div class="info-pill pill-injured">Heridos: <span class="info-pill-value"><?= $injured ?></span></div>
                        <div class="info-pill pill-losses">Pérdidas: <span class="info-pill-value">RD$ <?= $losses ?></span></div>
                    </div>
                </div>
            </div>

            <!-- Etiquetas -->
            <?php if ($labels): ?>
                <div class="mt-1rem">
                    <div class="section-title section-title-small">Etiquetas</div>
                    <div class="info-grid">
                        <div class="info-row labels-row" role="list" aria-label="Etiquetas">
                            <?php foreach ($labels as $label): ?>
                                <div class="info-pill">
                                    <?= $label['label_name'] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Botón para sugerir corrección -->
            <div class="text-end">
                <a id="btnGoToCorrectionPage"
                    class="btn btn-success btn-sm"
                    href="correction.php?incidence_id=<?= $incidenceId ?>">
                    Sugerir Corrección
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Comentarios -->
    <div class="mb-3">
        <h5 class="comments-heading">Comentarios <span class="small-muted">· <?= count($comments) ?></span></h5>

        <!-- Añadir comentario -->
        <div class="card card-section mb-3">
            <form method="post" action="incidence.php?id=<?= $incidenceId ?>&action=POST" class="form-comment" autocomplete="off">
                <div class="comment-form-row">
                    <div class="comment-avatar avatar-color-<?= $current_user_color_idx ?>" aria-hidden="true">
                        <?= $current_user_initial ?>
                    </div>
                    <div class="comment-form-body">
                        <textarea name="comment_text" class="form-control" placeholder="Añade un comentario..." required></textarea>
                        <div class="comment-form-actions">
                            <button type="submit" class="btn btn-primary">Comentar</button>
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
                    $ctext = $c['comment_text'];
                    $initial = strtoupper(substr($author, 0, 1));
                    $acolor_idx = avatar_color_index($author, $avatar_colors);
                    $is_comment_super = UserUtils::isUserSuper($c['user_id']);
                ?>
                    <div class="comment-row d-flex align-items-start<?= $is_comment_super ? ' comment-row-super' : '' ?>" role="article">
                        <!-- Avatar: clase de color en vez de style -->
                        <div class="comment-avatar<?= $is_comment_super ? ' comment-avatar-super' : '' ?> avatar-color-<?= $acolor_idx ?>" aria-hidden="true"><?= $initial ?></div>

                        <div class="comment-body">
                            <div class="d-flex align-items-center comment-author-row">
                                <div>
                                    <div class="comment-author">
                                        <?= $author ?>
                                        <?php if ($is_comment_super): ?>
                                            <!-- Badge para roles super -->
                                            <span class="badge-admin">ADMIN</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="comment-meta"><?= $cdate ?></div>
                                </div>

                                <div class="ms-auto d-flex align-items-center">
                                    <?php if (($is_super && !$is_comment_super) || $c['user_id'] == $user_id): ?>
                                        <!-- Botón de eliminar pequeño y elegante (Bootstrap) -->
                                        <form method="post" action="incidence.php?id=<?= $incidenceId ?>&action=DELETE" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="comment_id" value="<?= (int)$c['id'] ?>">
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar comentario">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                        </form>
                                </div>
                            </div>
                            <div class="comment-text"><?= $ctext ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>