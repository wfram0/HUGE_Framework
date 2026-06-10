<?php

class UploadModel
{
    public static function upload($file, $userID)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return;

        $db = DatabaseFactory::getFactory()->getConnection();

        $name = time() . "_" . basename($file['name']);
        $size = $file['size'];

        $dir = dirname(__DIR__, 2) . "/user_pictures/$userID";

        if (!is_dir($dir)) mkdir($dir, 0777, true);

        move_uploaded_file($file['tmp_name'], $dir . "/" . $name);

        $stmt = $db->prepare("
            INSERT INTO files (ownerID, name, size)
            VALUES (:ownerID, :name, :size)
        ");

        $stmt->execute([
            ':ownerID' => $userID,
            ':name' => $name,
            ':size' => $size
        ]);
    }
}