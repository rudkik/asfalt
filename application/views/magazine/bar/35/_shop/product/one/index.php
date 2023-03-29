<?php $isEdit = Request_RequestParams::getParamBoolean('is_edit'); ?>
<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <?php if($isEdit){?>
        <td>
            <input data-action="save-db" name="old_id" type="text" value="<?php echo $data->values['old_id']; ?>"
                   data-url="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $data->values); ?>">
        </td>
        <td>
            <input data-action="save-db" name="barcode" type="tel" value="<?php echo $data->values['barcode']; ?>"
                   data-url="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $data->values); ?>">
        </td>
    <?php }else{?>
        <td><?php echo $data->values['old_id']; ?></td>
        <td><?php echo $data->values['barcode']; ?></td>
    <?php }?>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['name_1c']; ?></td>
    <td><?php echo $data->getElementValue('shop_product_rubric_id'); ?></td>
    <td><?php echo $data->getElementValue('unit_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
