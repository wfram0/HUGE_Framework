<div class="container">
    <h1>Globaler Feed</h1>
    <?php foreach ($this->files as $file) { ?>
        <div class=file>
            <img src="<?= Config::get('URL'); ?>gallery/image/<?= $file->id ?>">
            <div>
                <?= htmlentities($file->user_name); ?>
            </div>
            <div>
                <?= $file->likes ?>
            </div>
            <a href="<?= Config::get('URL'); ?>gallery/like/<?= $file->id ?>" ?>
                Like
            </a>
        </div>
    <?php } ?>
</div>