<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <input name="shop_delivery_ids[<?php echo $data->values['id'];?>]" <?php if (Arr::path($data->additionDatas, 'group', '') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" data-id="1">
    </td>
</tr>
