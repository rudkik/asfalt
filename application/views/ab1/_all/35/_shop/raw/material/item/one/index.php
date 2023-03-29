<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <?php echo $data->getElementValue('shop_material_id', 'name', $data->getElementValue('shop_raw_id')); ?>
    </td>
    <td>
        <input data-id="norm" name="shop_raw_material_items[<?php echo $data->id; ?>][norm]" type="text" class="form-control" placeholder="Норма (%)" required value="<?php echo Func::getNumberStr($data->values['norm'], FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        <input name="shop_raw_material_items[<?php echo $data->id; ?>][shop_material_id]" value="<?php echo $data->values['shop_material_id']; ?>" style="display: none">
        <input name="shop_raw_material_items[<?php echo $data->id; ?>][shop_raw_id]" value="<?php echo $data->values['shop_raw_id']; ?>" style="display: none">
    </td>
    <td>
        <input data-id="quantity" type="text" class="form-control" placeholder="Кол-во (т)" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'quantity', 0), FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
</tr>
