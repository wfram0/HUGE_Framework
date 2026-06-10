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
}