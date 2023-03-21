<div class="container">
    <a class="button" href="/MVCProject/public/productcategories/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
    <table class="data">
        <thead>
            <tr>
                <th><?= $text_table_group_name ?></th>
                <th><?= $text_table_control ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($categories !== false): foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <?= $category->CategoryName ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/productcategories/edit/<?=$category->CategoryId?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/productcategories/delete/<?=$category->CategoryId?>" onclick="if(!confirm('<?=$text_table_control_delete_form?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>