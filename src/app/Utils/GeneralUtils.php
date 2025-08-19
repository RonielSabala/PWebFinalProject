<?php

namespace App\Utils;


class GeneralUtils
{
    public static function showAlert(
        string $message,
        string $type = 'danger',
        string $returnRoute = '',
        bool $showReturn = true
    ) {
        if ($showReturn && empty($returnRoute)) {
            $returnRoute = UriUtils::getNthUri(-2);
        }

        echo "
        <div class='text-center mt-2'>
            <div class='alert alert-$type'>$message</div>";
        if ($showReturn) {
            echo "<a href='$returnRoute' class='btn btn-primary mb-4'>Volver</a>";
        }
        echo "</div>";
    }

    public static function getActiveClass(string $page): string
    {
        $current = defined('CURRENT_PAGE') ? CURRENT_PAGE : '';
        return 'custom-link nav-link non-selectable' . ($current === $page ? ' active' : '');
    }

    public static function showNoData($entities, string $entities_name)
    {
        if ($entities) {
            return;
        }

        echo '
        <div id="noData" class="no-data">
            <i class="bi bi-inbox-fill fs-1 mb-2"></i>
            <div>No se encontraron ' . $entities_name . '.</div>
        </div>
        ';
    }

    public static function getUserDefaultRouteByRole($role)
    {
        $route = match ($role) {
            'reporter'  => '/reporters',
            'validator' => '/super/validator',
            'admin'     => '/super/admin',
            default     => '',
        };

        return $route . '/home.php';
    }
}
