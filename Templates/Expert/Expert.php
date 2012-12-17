<?php if (@$view['message_error']): ?></a><div class="message error"><?=$view['message_error']?></div><?php endif; ?>
<?php if (@$view['message_success']): ?></a><div class="message success"><?=$view['message_success']?></div><?php endif; ?>

<?php if ($view['items']): ?>
<form action="/Expert" method="post">
    <input type="hidden" name="form" value="request_items">
    <table class="table">
        <thead>
        <th>Наименование товара</th>
        <th>Общее количество товара</th>
        <th>Количество реализованного товара</th>
        <th>Количество утерянной продукции</th>
        <th>Нереализовано</th>
        </thead>
        <tbody>
        <?php foreach($view['items'] as $item): ?>
        <tr>
            <td><?=$item->name?></td>
            <td><?=$item->ware_count?></td>
            <td><?=$item->sold_count?></td>
            <td><input type="text" name="item[<?=$item->itemID?>]" value="0" onBlur="update(this.name);"></td>
            <td><span class="result[<?=$item->itemID?>]"><?=$item->result?></span></td>
            
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<?php endif; ?>

<script type="text/javascript">
var prev_value = 0;
var modified = false;

var update = function(th){
    var elem_val = document.getElementsByName(th)[0].value;
    if (elem_val != "Nan"){
        var res_name = 'result' + th.substr(4);
        var result_obj = document.getElementsByClassName(res_name)[0];        
        if (!modified)
        {
            prev_value = parseInt(elem_val);
            var result = parseInt(elem_val) + parseInt(result_obj.innerHTML);
                result_obj.innerHTML = result;
            modified = true;
        }
        else
        {
            var result = parseInt(elem_val) + parseInt(result_obj.innerHTML) - parseInt(prev_value);
            modified = false;
            prev_value = 0;
        }
    }
}

</script>
