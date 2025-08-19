<?php

$username = $_SESSION['user']['username'] ?? '';
$userRole = $_SESSION['user']['role_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Proyecto final. Grupo No. 1</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="/home.php">
                <div class="brand-text">
                    <span class="brand-title">Incidencias RD</span>
                    <span class="brand-sub">Transparencia y acción comunitaria.</span>
                </div>
            </a>

            <div class="actions">
                <a href="/incidents/map.php" class="incidents">
                    <i class="bi bi-flag-fill"></i>
                    <span class="incidents-label non-selectable">Incidencias</span>
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="user">
                        <details class="user-menu">
                            <summary class="user-summary">
                                <div class="avatar non-selectable"><?= $username[0] ?? '' ?></div>
                                <div class="user-names">
                                    <div class="user-name non-selectable"><?= $username ?></div>
                                    <div class="user-role non-selectable"><?= ($userRole === 'default') ? '' : $userRole ?></div>
                                </div>
                            </summary>
                            <a href="/auth/logout.php" class="btn logout-btn btn-outline-danger btn-sm">Cerrar sesión</a>
                        </details>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>