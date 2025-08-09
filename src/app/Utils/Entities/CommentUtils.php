<?php

namespace App\Utils\Entities;


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

    public static function getAllByIncidenceId($incidenceId): array
    {
        return self::fetchAllSql(self::$getAllByIncidenceIdSql, [$incidenceId]);
    }
}
