<form method="post" action="<?= Config::get('URL'); ?>gallery/upload" enctype="multipart/form-data">

    <input type="file" name="datei">
    <button type="submit">Upload</button>

</form>

<style>
.file {
    display: inline-block;
    width: 180px;
    margin: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

.file img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    margin-bottom: 8px;
}

.file div {
    word-break: break-word;
}

.file a {
    display: block;
    margin: 4px 0;
    padding: 6px;
    text-decoration: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #000;
}
</style>

<div class="container">

    <h1>Meine Galerie</h1>

    <?php foreach ($this->files as $file) { ?>

        <div class="file">

            <img src="<?= Config::get('URL'); ?>gallery/image/<?= $file->id ?>">

            <div><?= htmlentities($file->name); ?></div>

            <a href="<?= Config::get('URL'); ?>gallery/download/<?= $file->id ?>">
                Download
            </a>

            <a href="<?= Config::get('URL'); ?>gallery/delete/<?= $file->id ?>"
               onclick="return confirm('Wirklich löschen?')">
                Löschen
            </a>

            <?php if ($file->shared == 0) { ?>
                <a href="<?= Config::get('URL'); ?>gallery/share/<?= $file->id ?>">
                    Freigeben
                </a>
            <?php } else { ?>
                <div>✔ Freigegeben</div>
            <?php } ?>

        </div>

    <?php } ?>

</div>