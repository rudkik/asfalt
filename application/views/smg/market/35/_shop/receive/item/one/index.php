<tr data-action="set-drop" data-id="<?php echo $data->values['id']; ?>" data-quantity="<?php echo $data->values['quantity']; ?>">
    <td class="text-right">#index#</td>
    <td class="text-center">
        <input name="set-is-public" <?php if ($data->values['is_expense'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-field="is_expense" data-id="<?php echo $data->id; ?>">
    </td>
    <td class="text-center">
        <input name="set-is-public" <?php if ($data->values['is_store'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-field="is_store" data-id="<?php echo $data->id; ?>">
    </td>
    <td class="text-center">
        <input name="set-is-public" <?php if ($data->values['is_return'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-field="is_return" data-id="<?php echo $data->id; ?>">
    </td>
    <td data-id="shop-bill-item-id">
        <span><?php if ($data->values['shop_bill_item_id'] > 0) { echo $data->values['shop_bill_item_id']; } ?></span>
        <a data-action="del-bill-item" href="<?php echo Func::getFullURL($siteData, '/shopreceive/del_bill_item', ['id' => 'id'], [], $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i></a>
    </td>
    <td>
        <?php echo $data->values['name']; ?>
        <?php if ($data->values['shop_product_id'] > 0){ ?>
            <br><?php echo $data->getElementValue('shop_product_id'); ?>
        <?php } ?>
        <a data-action="select-receive-item" href="#" class="text-blue" style="font-weight: bold">Выбрать</a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], true); ?></td>
</tr>