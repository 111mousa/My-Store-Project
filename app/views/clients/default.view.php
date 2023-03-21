<div class="container">
    <a class="button" href="/MVCProject/public/clients/create"><i class="fa fa-plus"></i><?= $text_new_item ?></a>
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
            <?php if ($clients !== false) : foreach ($clients as $client) : ?>
                    <tr>
                        <td>
                            <?= $client->Name ?>
                        </td>
                        <td>
                            <?= $client->Email ?>
                        </td>
                        <td>
                            <?= $client->PhoneNumber ?>
                        </td>
                        <td>
                            <?= $client->Address ?>
                        </td>
                        <td>
                            <a href="/MVCProject/public/clients/edit/<?= $client->ClientId ?>"><i class="fa fa-edit"></i></a>
                            <a href="/MVCProject/public/clients/delete/<?= $client->ClientId ?>" onclick="if(!confirm('<?= $text_table_control ?>'))return false;"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
            <?php endforeach;
            endif; ?>
        </tbody>
    </table>
</div>