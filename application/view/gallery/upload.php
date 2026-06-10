<form method="post"
      action="<?= Config::get('URL'); ?>gallery/upload"
      enctype="multipart/form-data">

    <input type="file" name="datei">
    <button type="submit">Upload</button>

</form>