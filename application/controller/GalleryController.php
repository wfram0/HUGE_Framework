<?php

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index()
    {
        $this->View->render('gallery/gallery', [
            'files' => FileModel::getByUser(Session::get('user_id'))
        ]);
    }

    public function upload()
    {
        if (!isset($_FILES['datei'])) {
            Redirect::to('gallery');
            return;
        }

        UploadModel::upload(
            $_FILES['datei'],
            Session::get('user_id')
        );

        Redirect::to('gallery');
    }

    public function image($id)
    {
        $file = FileModel::getById($id);

        if (!$file) {
            die("File not found");
        }

        if ($file->ownerID != Session::get('user_id') && $file->shared == 0) {
            die("No access");
        }

        $path = dirname(__DIR__, 2)
            . '/user_pictures/'
            . $file->ownerID
            . '/'
            . $file->name;

        if (!file_exists($path)) {
            die("Missing file");
        }

        header('Content-Type: ' . mime_content_type($path));
        readfile($path);
        exit;
    }

    public function delete($id)
    {
        FileModel::deleteFile($id, Session::get('user_id'));
        Redirect::to('gallery');
    }

    public function download($id)
    {
        $file = FileModel::getById($id);

        if (!$file) {
            die("File not found");
        }

        if ($file->ownerID != Session::get('user_id') && $file->shared == 0) {
            die("No access");
        }

        $path = dirname(__DIR__, 2)
            . '/user_pictures/'
            . $file->ownerID . '/'
            . $file->name;

        if (!file_exists($path)) {
            die("Missing file");
        }

        // Counter erhöhen
        FileModel::increaseDownload($id);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file->name . '"');
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }

    public function share($id)
    {
        $token = FileModel::generateShareToken(
            $id,
            Session::get('user_id')
        );

        echo "Share Link: " . Config::get('URL') . "gallery/s/" . $token;
    }

    public function s($token)
    {
        $file = FileModel::getByToken($token);

        if (!$file) {
            die("Invalid link");
        }

        $path = dirname(__DIR__, 2)
            . '/user_pictures/'
            . $file->ownerID
            . '/'
            . $file->name;

        header('Content-Type: ' . mime_content_type($path));
        readfile($path);
        exit;
    }
}