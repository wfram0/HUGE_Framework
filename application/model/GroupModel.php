<?php

class GroupModel
{
    public static function getAllGroups()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM groups ORDER BY group_name";

        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getGroup($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM groups
                WHERE group_id = :group_id";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id
        ));

        return $query->fetch();
    }
}