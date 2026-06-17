<?php

class LikeModel
{
    public static function like($userId, $fileId)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            INSERT IGNORE INTO image_likes
            (user_id, file_id)
            VALUES
            (:user_id, :file_id)
        ";

        $query = $db->prepare($sql);

        $query->execute([
            ':user_id' => $userId,
            ':file_id' => $fileId
        ]);
    }

    public static function unlike($userId, $fileId)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            DELETE FROM image_likes
            WHERE user_id = :user_id
            AND file_id = :file_id
        ";

        $query = $db->prepare($sql);

        $query->execute([
            ':user_id' => $userId,
            ':file_id' => $fileId
        ]);
    }

    public static function hasLiked($userId, $fileId)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            SELECT *
            FROM image_likes
            WHERE user_id = :user_id
            AND file_id = :file_id
        ";

        $query = $db->prepare($sql);

        $query->execute([
            ':user_id' => $userId,
            ':file_id' => $fileId
        ]);

        return $query->rowCount() > 0;
    }
}