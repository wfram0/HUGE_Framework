<div class="container">

    <h2>Chat</h2>

    <div class="chat-container">

        <?php foreach ($this->messages as $message) { ?>

            <?php if ($message->sender_id == Session::get('user_id')) { ?>

                <div class="message own">
                    <?= htmlspecialchars($message->message); ?>
                </div>

            <?php } else { ?>

                <div class="message other">
                    <?= htmlspecialchars($message->message); ?>
                </div>

            <?php } ?>

        <?php } ?>

    </div>

    <form method="post"
          action="<?= Config::get('URL'); ?>messenger/send">

        <input type="hidden"
               name="receiver_id"
               value="<?= $this->receiver_id; ?>">

        <input type="text"
               name="message"
               required>

        <button type="submit">
            Send
        </button>

    </form>

</div>