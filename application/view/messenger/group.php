<div class="container">

    <h2>
        <?= htmlspecialchars($this->group->group_name); ?>
    </h2>

    <div class="chat-container">

        <?php foreach ($this->messages as $message) { ?>

            <?php if (
                $message->sender_id ==
                Session::get('user_id')
            ) { ?>

                <div class="message own">
                    <?= htmlspecialchars($message->message); ?>
                </div>

            <?php } else { ?>

                <div class="message other">

                    <strong>
                        <?= htmlspecialchars($message->user_name); ?>
                    </strong>

                    <br>

                    <?= htmlspecialchars($message->message); ?>

                </div>

            <?php } ?>

        <?php } ?>

    </div>

    <form method="post"
          action="<?= Config::get('URL'); ?>messenger/sendgroup">

        <input type="hidden"
               name="group_id"
               value="<?= $this->group->group_id; ?>">

        <input type="text"
               name="message"
               required>

        <button type="submit">
            Send
        </button>

    </form>

</div>