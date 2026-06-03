<?php
class MessageModel
{
    public static function sendMessage($sender_id, $receiver_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_send_message(
                    :sender_id,
                    :receiver_id,
                    :message
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':message' => $message
        ));
    }

    public static function getConversation($user1, $user2)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_conversation(
                    :user1,
                    :user2
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user1' => $user1,
            ':user2' => $user2
        ));

        return $query->fetchAll();
    }

    public static function markMessagesAsRead($sender_id, $receiver_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_mark_messages_read(
                    :sender_id,
                    :receiver_id
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id
        ));
    }

    public static function countUnreadMessages($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_count_unread_messages(
                    :user_id
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        $result = $query->fetch();

        return $result->amount;
    }

    public static function sendGroupMessage($sender_id, $group_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_send_group_message(
                    :sender_id,
                    :group_id,
                    :message
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':sender_id' => $sender_id,
            ':group_id' => $group_id,
            ':message' => $message
        ));
    }

    public static function getGroupConversation($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_get_group_conversation(
                    :group_id
                )";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id
        ));

        return $query->fetchAll();
    }
}
?>