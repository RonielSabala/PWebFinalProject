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
    ORDER BY
        c.creation_date
    DESC
    ";

    private static $createSql = "INSERT INTO
    comments (
        incidence_id,
        user_id,
        comment_text
    )
    VALUES
        (?, ?, ?)
    ";

    public static function getAllByIncidenceId($incidenceId): array
    {
        return self::fetchAllSql(self::$getAllByIncidenceIdSql, [$incidenceId]);
    }

    public static function create($commentText, $userId, $incidenceId): bool
    {
        return self::executeSql(self::$createSql, [$incidenceId, $userId, $commentText]);
    }
}
