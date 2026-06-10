<form method="post"
      action="<?= Config::get('URL'); ?>gallery/upload"
      enctype="multipart/form-data">

    <input type="file" name="datei">
    <button type="submit">Upload</button>

</form>

<div class="container">

    <h1>Meine Galerie</h1>

    <?php if ($this->files) { ?>

        <?php foreach ($this->files as $file) { ?>

            <div>

                <p><?= htmlentities($file->name); ?></p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>Keine Bilder vorhanden.</p>

    <?php } ?>

</div>