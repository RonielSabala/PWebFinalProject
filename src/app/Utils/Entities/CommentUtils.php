<?php

namespace App\Utils\Entities;

use PDO;


class CommentUtils
{
    private static $getByIncidenceIdSQL = "SELECT
        u.username,
        c.comment_text,
        c.creation_date
    FROM comments AS c
    JOIN users    AS u ON u.id = c.user_id
    WHERE c.incidence_id = ?
    ";

    public static function getAllByIncidenceId($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIncidenceIdSQL);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
