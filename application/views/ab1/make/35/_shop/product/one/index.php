<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['name_1c']; ?></td>
    <td><?php echo $data->values['name_short']; ?></td>
    <td><?php echo $data->getElementValue('shop_product_rubric_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_group_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('product_type_id'); ?>
        <br><?php echo $data->getElementValue('product_view_id'); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_subdivision_id'); ?>
        <br><?php echo $data->getElementValue('shop_storage_id'); ?>
    </td>
    <td><?php echo $data->values['unit']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo $data->values['order']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/edit', array('id' => 'id'), array(), $data->values, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array(), $data->values, false, true); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array('is_undel' => 1), $data->values, false, true); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
