<div class="container">
    <a class="button" href="/MVCProject/public/users/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
    <table class="data">
        <thead>
            <tr>
                <th><?= $text_table_username ?></th>
                <th><?= $text_table_group ?></th>
                <th><?= $text_table_email ?></th>
                <th><?= $text_table_subscribtion_date ?></th>
                <th><?= $text_table_last_login ?></th>
                <th><?= $text_table_employee_control ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($users !== false) : foreach ($users as $user) : ?>
                    <tr>
                        <td>
                            <?= $user->UserName ?>
                        </td>
                        <td>
                            <?= $user->GroupName ?>
                        </td>
                        <td>
                            <?= $user->Email ?>
                        </td>
                        <td>
                            <?= $user->SubscribtionDate ?>
                        </td>
                        <td>
                            <?= $user->LastLogin ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/users/edit/<?= $user->UserId ?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/users/delete/<?= $user->UserId ?>" onclick="if(!confirm('<?= $text_table_control_delete_form ?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
            <?php endforeach;
            endif; ?>
        </tbody>
    </table>
</div>