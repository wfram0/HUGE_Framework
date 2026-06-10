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
}