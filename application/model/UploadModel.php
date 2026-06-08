<?php

class UploadModel
{
    public static function upload($file, $userID, $pdo)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Fehler");
        }

        $name = time() . "_" . basename($file['name']);
        $size = $file['size'];

        $uploadDir = dirname(__DIR__, 2) . "/Huge/userpictures/$userID";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ziel = $uploadDir . "/" . $name;

        move_uploaded_file($file['tmp_name'], $ziel);

        $stmt = $pdo->prepare("
            INSERT INTO files (ownerID, name, size)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([$userID, $name, $size]);
    }
}
?>