<?php

class FileModel
{
    public static function getByUser($userID, $pdo)
    {
        $stmt = $pdo->prepare("
            SELECT *
            FROM files
            WHERE ownerID = ?
        ");

        $stmt->execute([$userID]);

        return $stmt->fetchAll();
    }
}

?>