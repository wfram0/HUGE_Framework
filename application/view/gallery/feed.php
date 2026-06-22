<div class="container">
    <h1>Globaler Feed</h1>

    <?php foreach ($this->files as $file) { ?>

        <?php
        $isLiked = LikeModel::hasLiked(Session::get('user_id'), $file->id);
        ?>

        <div class="feed-post">

            <img class="feed-image"
                 src="<?= Config::get('URL'); ?>gallery/image/<?= $file->id ?>">

            <div class="feed-user">
                <?= htmlentities($file->user_name); ?>
            </div>

            <div class="feed-likes">
                👍 <?= $file->likes ?>
            </div>

            <?php if ($isLiked) { ?>
                <a class="feed-like"
                   href="<?= Config::get('URL'); ?>gallery/unlike/<?= $file->id ?>">
                    Unlike
                </a>
            <?php } else { ?>
                <a class="feed-like"
                   href="<?= Config::get('URL'); ?>gallery/like/<?= $file->id ?>">
                    Like
                </a>
            <?php } ?>

        </div>

    <?php } ?>
</div>