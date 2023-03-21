<div class="container">
    <a class="button" href="/MVCProject/public/privileges/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
    <table class="data">
        <thead>
            <tr>
                <th><?= $text_table_privilege ?></th>
                <th><?= $text_table_control ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($privileges !== false): foreach ($privileges as $privilege): ?>
                    <tr>
                        <td>
                            <?= $privilege->getPrivilegeTitle() ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/privileges/edit/<?=$privilege->PrivilegeId?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/privileges/delete/<?=$privilege->PrivilegeId?>" onclick="if(!confirm('<?=$text_table_control_delete_form?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>