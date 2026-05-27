<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
            This controller/action/view shows a list of all users in the system. with the ability to soft delete a user
            or suspend a user.
        </div>
        <div>
            <table id="datatable" class="overview-table">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Avatar</td>
                        <td>Username</td>
                        <td>User's email</td>
                        <td>Group</td>
                        <td>Activated ?</td>
                        <td>Link to user's profile</td>
                        <td>suspension Time in days</td>
                        <td>Soft delete</td>
                        <td>Submit</td>
                    </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>" />
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                        <td><?= $user->group_name; ?></td>
                        <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
                        </td>
                        <td>
                            <input type="number" name="suspension" />
                        </td>

                        <td>
                            <input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> />
                        </td>

                        <td>
                            <form action="<?= Config::get("URL"); ?>admin/actionAccountSettings" method="post">

                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />

                                <select name="user_group">
                                    <option value="1" <?= ($user->group_name == 1 ? 'selected' : ''); ?>>Gast</option>
                                    <option value="2" <?= ($user->group_name == 2 ? 'selected' : ''); ?>>User</option>
                                    <option value="7" <?= ($user->group_name == 7 ? 'selected' : ''); ?>>Admin</option>
                                </select>

                                <button type="submit">Submit</button>

                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>