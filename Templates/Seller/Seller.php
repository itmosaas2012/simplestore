
<?php if (@$view['message_error']): ?></a><div class="message error"><?=$view['message_error']?></div><?php endif; ?>
<?php if (@$view['message_success']): ?></a><div class="message success"><?=$view['message_success']?></div><?php endif; ?>

<style>
    .table th, .table td {
        padding: 12px;
    }
</style>

<?php if ($view['items']): ?>
<form action="/Seller" method="post">
    <input type="hidden" name="form" value="request_items">
    <table class="table">
        <thead>
        <th>Наименование товара</th>
        <th>Общее количество товара</th>
        <th>Количество реализованного товара</th>
        </thead>
        <tbody>
        <?php foreach($view['items'] as $item): ?>
        <tr>
            <td><?=$item->name?></td>
            <td><?=$item->ware_count?></td>
            <td><input type="text" name="item[<?=$item->itemID?>]" value="0"></td>
        </tr>
            <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align: right;"><button class="btn btn-primary btn-small" type="submit">Продолжить</button></td>
        </tr>
        </tbody>
    </table>
</form>
<?php endif; ?>