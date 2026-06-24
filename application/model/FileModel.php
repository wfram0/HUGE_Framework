<?php

class FileModel
{
    public static function getByUser($userID)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
            SELECT *
            FROM files
            WHERE ownerID = :ownerID
            ORDER BY id DESC
        ";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':ownerID' => $userID
        ));

        return $query->fetchAll();
    }

    public static function getById($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM files WHERE id = :id";
        $query = $db->prepare($sql);
        $query->execute([':id' => $id]);

        return $query->fetch();
    }

    public static function deleteFile($id, $userID)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        // Datei holen
        $sql = "SELECT * FROM files WHERE id = :id AND ownerID = :ownerID";
        $query = $db->prepare($sql);
        $query->execute([
            ':id' => $id,
            ':ownerID' => $userID
        ]);

        $file = $query->fetch();
        if (!$file)
            return;

        // Pfad
        $path = dirname(__DIR__, 2)
            . '/user_pictures/'
            . $file->ownerID . '/'
            . $file->name;

        // Datei löschen
        if (file_exists($path)) {
            unlink($path);
        }

        // DB löschen
        $sql = "DELETE FROM files WHERE id = :id AND ownerID = :ownerID";
        $query = $db->prepare($sql);
        $query->execute([
            ':id' => $id,
            ':ownerID' => $userID
        ]);
    }

    public static function increaseDownload($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE files
            SET downloads = downloads + 1
            WHERE id = :id";

        $query = $db->prepare($sql);
        $query->execute([':id' => $id]);
    }

    public static function generateShareToken($id, $userID)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $token = bin2hex(random_bytes(16));

        $sql = "UPDATE files
            SET share_token = :token, shared = 1
            WHERE id = :id AND ownerID = :ownerID";

        $query = $db->prepare($sql);
        $query->execute([
            ':token' => $token,
            ':id' => $id,
            ':ownerID' => $userID
        ]);

        return $token;
    }

    public static function getByToken($token)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM files WHERE share_token = :token";
        $query = $db->prepare($sql);
        $query->execute([':token' => $token]);

        return $query->fetch();
    }

    public static function getSharedFiles()
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT
            files.*,
            users.user_name,
            COUNT(image_likes.file_id) AS likes
        FROM files

        INNER JOIN users
            ON files.ownerID = users.user_id

        LEFT JOIN image_likes
            ON files.id = image_likes.file_id

        WHERE files.shared = 1

        GROUP BY files.id

        ORDER BY files.id DESC
    ";

        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getImageOfTheWeek()
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT
            files.*,
            users.user_name,
            COUNT(image_likes.file_id) AS likes
        FROM files

        INNER JOIN users
            ON files.ownerID = users.user_id

        LEFT JOIN image_likes
            ON files.id = image_likes.file_id

        WHERE files.shared = 1
        AND YEARWEEK(image_likes.created_at, 1) = YEARWEEK(NOW(), 1)

        GROUP BY files.id

        ORDER BY likes DESC

        LIMIT 1
    ";

        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetch();
    }
}