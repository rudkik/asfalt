<tr>
    <td>
        <input class="form-control" placeholder="Комната" type="text" value="<?php echo $data->getElementValue('shop_room_id'); ?>">
        <input name="shop_pricelist_items[<?php echo $data->id; ?>][shop_room_id]" value="<?php echo $data->values['shop_room_id']; ?>" style="display: none">
    </td>
    <td>
        <input name="shop_pricelist_items[<?php echo $data->id; ?>][price]" class="form-control" type="text" value="<?php echo Arr::path($data->values, 'price', ''); ?>">
    </td>
    <td>
        <input name="shop_pricelist_items[<?php echo $data->id; ?>][price_feast]" class="form-control" type="text" value="<?php echo Arr::path($data->values, 'price_feast', ''); ?>">
    </td>
    <td>
        <input name="shop_pricelist_items[<?php echo $data->id; ?>][price_extra]" class="form-control" type="text" value="<?php echo Arr::path($data->values, 'price_extra', ''); ?>">
    </td>
    <td>
        <input name="shop_pricelist_items[<?php echo $data->id; ?>][price_child]" class="form-control" type="text" value="<?php echo Arr::path($data->values, 'price_child', ''); ?>">
    </td>
</tr>