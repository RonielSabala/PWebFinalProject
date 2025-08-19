<?php

use App\Utils\PrintUtils;
use App\Utils\Entities\UserUtils;

// Datos
$photos = $incidence['photo_urls'];
$incidenceId = $incidence['id'];
$title = $incidence['title'];
$description = $incidence['incidence_description'];
$isApproved = $incidence['is_approved'];
$reporterId = $incidence['reporter_id'];
$reporterName = $incidence['reporter_name'];
$occurrence = PrintUtils::getPrintableDate($incidence['occurrence_date']);
$created = PrintUtils::getPrintableDate($incidence['creation_date']);
$deaths = $incidence['n_deaths'];
$injured = $incidence['n_injured'];
$losses = number_format((float)($incidence['n_losses']), 2, ',', '.');

if (!empty($photos)) {
    $photos = array_map('trim', explode(',', $incidence['photo_urls']));
}

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
$isUserSuper = UserUtils::isUserSuper($user_id);
$current_user_initial = strtoupper(substr($username, 0, 1));
$current_user_color_idx = avatar_color_index($username, $avatar_colors);
?>

<div class="incidence-container">
    <div class="card-min mb-4">
        <!-- Cabecera -->
        <div class="incidence-header">
            <div class="incidence-card">
                <div class="incidence-main">
                    <div class="incidence-top">
                        <span class="kicker"><?= empty($labels) ? 'NOTICIA' : strtoupper($labels[0]['label_name']) ?></span>
                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16" focusable="false">
                            <path d="M12 2l2.1 4.6L19 8l-3.6 2.8L16 16l-4-2.5L8 16l.6-5.2L5 8l4.9-1.4L12 2z" />
                        </svg>
                    </div>

                    <h2 id="incidence-title" class="title"><?= $title ?></h2>
                    <p class="incidence-meta" aria-label="Metadatos de la noticia">
                        <time datetime="<?= date('c', strtotime($created)) ?>">Fecha de publicación: <strong><?= $created ?></strong></time>
                        <span class="dot"></span>
                        <span>Ocurrencia: <strong><?= $occurrence ?></strong></span>
                        <span class="dot"></span>
                        <span>Publicado por: <strong><?= $reporterName ?></strong></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="card-section pb-4">
            <!-- Descripción -->
            <div class="section-description">
                <div id="desc-title" class="section-title">Descripción</div>
                <div class="description-text">
                    <?= PrintUtils::getPrintableText($description) ?>
                </div>
                <div class="sr-only" aria-hidden="false">Enlaces en azul; cada enlace aparece en una línea separada.</div>
            </div>

            <!-- Detalles -->
            <div class="mt-1rem">
                <div class="section-title">Detalles</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-pill pill-deaths">Muertos: <span class="info-pill-value"><?= $deaths ?></span></div>
                        <div class="info-pill pill-injured">Heridos: <span class="info-pill-value"><?= $injured ?></span></div>
                        <div class="info-pill pill-losses">Pérdidas: <span class="info-pill-value">RD$ <?= $losses ?></span></div>
                    </div>
                </div>
            </div>

            <!-- Carrusel de imágenes -->
            <?php if (!empty($photos)): ?>
                <div class="section-title text-center">Imágenes</div>

                <section class="container-carousel">
                    <div class="slider-wrapper">
                        <button class="carousel-arrow arrow-left">&lt;</button>
                        <div class="slider" id="slider">
                            <?php foreach ($photos as $index => $photo): ?>
                                <img
                                    class="slide"
                                    data-index="<?= $index ?>"
                                    id="slide-<?= $index + 1 ?>"
                                    src="<?= htmlspecialchars($photo) ?>"
                                    alt="Foto de la incidencia <?= $index + 1 ?>" />
                            <?php endforeach; ?>
                        </div>

                        <button class="carousel-arrow arrow-right">&gt;</button>
                        <div class="slider-nav" id="sliderNav" aria-label="Carousel navigation">
                            <?php foreach ($photos as $index => $photo): ?>
                                <button class="dot" type="button" data-index="<?= $index ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <div class="section-title">Imágenes</div>

                <section class="container-carousel no-photos">
                    <div class="no-photos-card">
                        <!-- Icono SVG -->
                        <div class="no-photos-icon" aria-hidden="true">
                            <svg width="96" height="72" viewBox="0 0 96 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1" y="1" width="94" height="70" rx="10" stroke="currentColor" stroke-opacity="0.12" stroke-width="2" fill="none" />
                                <g transform="translate(14,12)" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="0" y="6" width="68" height="44" rx="6" fill="none" stroke-opacity="0.14"></rect>
                                    <circle cx="14" cy="20" r="6" fill="none" stroke-opacity="0.14"></circle>
                                    <path d="M68 6 L48 30 L34 20 L0 46" fill="none" stroke-opacity="0.14"></path>
                                </g>
                                <path d="M18 56 L78 16" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-opacity="0.08" />
                            </svg>
                        </div>

                        <div class="no-photos-text">
                            <h3 id="noPhotosText">No hay imágenes <i class="bi bi-images"></i></h3>
                            <?php if ($isApproved): ?>
                                <p class="muted">No hay fotos disponibles para esta incidencia.</p>
                            <?php else: ?>
                                <p class="muted">Aún no se han subido fotos para esta incidencia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Etiquetas -->
            <?php if ($labels): ?>
                <div class="mt-1rem">
                    <div class="section-title">Etiquetas</div>
                    <div class="info-grid">
                        <div class="info-row labels-row" aria-label="Etiquetas">
                            <?php foreach ($labels as $label): ?>
                                <div class="info-pill info-pill-label">
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
                    class="btn btn-outline-success btn-sm"
                    href="correction.php?incidence_id=<?= $incidenceId ?>">
                    Corregir
                    <i class="bi bi-pencil-square"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Comentarios -->
    <div>
        <h5 class="comments-heading">Comentarios <span class="small-muted">· <?= count($comments) ?></span></h5>

        <!-- Añadir comentario -->
        <div class="card card-section pb-3 mb-3">
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
        <div class="card card-section pb-4">
            <?php if (empty($comments)): ?>
                <div class="py-4 text-center small-muted">Aún no hay comentarios. Sé el primero en comentar.</div>
            <?php else: ?>
                <?php foreach ($comments as $c):
                    $author = htmlspecialchars($c['username'] ?? 'Usuario');
                    $cdate = isset($c['creation_date']) ? PrintUtils::getPrintableDate($c['creation_date']) : '';
                    $ctext = $c['comment_text'];
                    $initial = strtoupper(substr($author, 0, 1));
                    $acolor_idx = avatar_color_index($author, $avatar_colors);
                    $userId = $c['user_id'];
                    $isValidator = UserUtils::isUserValidator($userId);
                    $isAdmin = UserUtils::isUserAdmin($userId);

                    // Obtener estilo del comentario según rol
                    $commentRow = '';
                    $commentAvatar = '';
                    $badge = [];
                    if ($userId == $reporterId) {
                        $commentRow = 'comment-row-reporter';
                        $commentAvatar = 'comment-avatar-reporter';
                        $badge = ['badge-reporter', 'REPORTER'];
                    } elseif ($isValidator) {
                        $commentRow = 'comment-row-validator';
                        $commentAvatar = 'comment-avatar-validator';
                        $badge = ['badge-validator', 'VALIDATOR'];
                    } elseif ($isAdmin) {
                        $commentRow = 'comment-row-admin';
                        $commentAvatar = 'comment-avatar-admin';
                        $badge = ['badge-admin', 'ADMIN'];
                    }
                ?>
                    <div class="comment-row d-flex align-items-start <?= $commentRow ?>">
                        <!-- Avatar: clase de color en vez de style -->
                        <div class="comment-avatar <?= $commentAvatar ?> avatar-color-<?= $acolor_idx ?>" aria-hidden="true"><?= $initial ?></div>

                        <div class="comment-body">
                            <div class="d-flex align-items-center comment-author-row">
                                <div>
                                    <div class="comment-author">
                                        <?= $author ?>
                                        <?php if (!empty($badge)): ?>
                                            <span class="<?= $badge[0] ?>"><?= $badge[1] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="comment-meta"><?= $cdate ?></div>
                                </div>

                                <div class="ms-auto d-flex align-items-center">
                                    <?php if ($isUserSuper || $c['user_id'] == $user_id): ?>
                                        <!-- Botón de eliminar pequeño y elegante (Bootstrap) -->
                                        <form method="post" action="incidence.php?id=<?= $incidenceId ?>&action=DELETE" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="comment_id" value="<?= (int)$c['id'] ?>">
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar comentario">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="comment-text"><?= PrintUtils::getPrintableText($ctext) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>