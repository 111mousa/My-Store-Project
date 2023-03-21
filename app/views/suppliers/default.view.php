<div class="container">
    <a class="button" href="/MVCProject/public/suppliers/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
    <table class="data">
        <thead>
            <tr>
                <th><?= $text_table_name ?></th>
                <th><?= $text_table_email ?></th>
                <th><?= $text_table_phone_number ?></th>
                <th><?= $text_table_address ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($suppliers !== false) : foreach ($suppliers as $supplier) : ?>
                    <tr>
                        <td>
                            <?= $supplier->Name ?>
                        </td>
                        <td>
                            <?= $supplier->Email ?>
                        </td>
                        <td>
                            <?= $supplier->PhoneNumber ?>
                        </td>
                        <td>
                            <?= $supplier->Address ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/suppliers/edit/<?= $supplier->SuplierId ?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/suppliers/delete/<?= $supplier->SuplierId ?>" onclick="if(!confirm('<?= $text_table_control ?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
            <?php endforeach;
            endif; ?>
        </tbody>
    </table>
</div>