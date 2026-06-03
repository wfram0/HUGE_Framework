<?php

class GroupModel
{
    public static function getAllGroups()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_all_groups()";

        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function getGroup($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_group(
                    :group_id
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id
        ));

        return $query->fetch();
    }
}