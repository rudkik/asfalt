<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo $data->getElementValue('shop_id'); ?></td>
    <td><?php echo $data->getElementValue('branch_move_id'); ?></td>
    <td class="text-right"><?php echo $data->values['quantity']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopmove/edit', array('id' => 'id'), array('shop_branch_id' => $data->values['shop_id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmove/del', array('id' => 'id'), array('shop_branch_id' => $data->values['shop_id']), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmove/del', array('id' => 'id'), array('is_undel' => 1, 'shop_branch_id' => $data->values['shop_id']), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
