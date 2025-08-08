<?php

namespace App\Utils\Entities;

use PDO;


class CommentUtils extends GenericEntityUtils
{
    private static $getAllByIncidenceIdSql = "SELECT
        u.username,
        c.comment_text,
        c.creation_date
    FROM
        comments c
    JOIN
        users u
    ON
        u.id = c.user_id
    WHERE
        c.incidence_id = ?
    ";

    public static function getAllByIncidenceId($incidenceId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getAllByIncidenceIdSql);
        $stmt->execute([$incidenceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
