<tr>
    <td class="text-center">
        <input name="set-is-public" <?php if ($data->values['is_store'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>" data-field="is_store">
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_receive_id', 'date')); ?>
    </td>
    <td>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array(), array('id' => $data->values['shop_receive_id'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('shop_receive_id', 'number'); ?></a>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_product_id', 'name', $data->values['name']); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_balance'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'] * $data->values['quantity_balance'], true); ?></td>
</tr>