<div class="container">
    <a class="button" href="/MVCProject/public/usersgroups/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
    <table class="data">
        <thead>
            <tr>
                <th><?= $text_table_group_name ?></th>
                <th><?= $text_table_control ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($groups !== false): foreach ($groups as $group): ?>
                    <tr>
                        <td>
                            <?= $group->GroupName ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/usersgroups/edit/<?=$group->GroupId?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/usersgroups/delete/<?=$group->GroupId?>" onclick="if(!confirm('<?=$text_table_control_delete_form?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>