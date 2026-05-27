<?php
class MessageModel
{
    public static function sendMessage($sender_id, $receiver_id, $message)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages
                (sender_id, receiver_id, message)
                VALUES (:sender_id, :receiver_id, :message)";

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

        $sql = "SELECT *
                FROM messages
                WHERE
                    (sender_id = :user1 AND receiver_id = :user2)
                OR
                    (sender_id = :user2 AND receiver_id = :user1)
                ORDER BY created_at ASC";

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

        $sql = "UPDATE messages
                SET was_read = 1
                WHERE sender_id = :sender_id
                AND receiver_id = :receiver_id";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id
        ));
    }

    public static function countUnreadMessages($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(*) AS amount
                FROM messages
                WHERE receiver_id = :user_id
                AND was_read = 0";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        $result = $query->fetch();

        return $result->amount;
    }
}
?>