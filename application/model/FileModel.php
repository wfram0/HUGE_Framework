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
}