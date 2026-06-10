<form method="post" action="<?= Config::get('URL'); ?>gallery/upload" enctype="multipart/form-data">

    <input type="file" name="datei">
    <button type="submit">Upload</button>

</form>

<div class="container">

    <h1>Meine Galerie</h1>

    <?php if ($this->files) { ?>

        <?php foreach ($this->files as $file) { ?>

            <div>
                <img src="<?= Config::get('URL'); ?>gallery/image/<?= $file->id ?>" width="150">
                <p><?= htmlentities($file->name); ?></p>
                <a href="<?= Config::get('URL'); ?>gallery/delete/<?= $file->id ?>"
                    onclick="return confirm('Wirklich löschen?')">
                    Löschen
                </a>
                <a href="<?= Config::get('URL'); ?>gallery/download/<?= $file->id ?>">
                    Download
                </a>
            </div>

        <?php } ?>

    <?php } else { ?>

        <p>Keine Bilder vorhanden.</p>

    <?php } ?>

</div>