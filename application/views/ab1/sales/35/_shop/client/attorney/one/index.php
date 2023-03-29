<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?>
        <br><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['attorney_updated_at']); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['to_at']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_client_id', 'balance_cache'), TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_client_id', 'balance'), TRUE, 2, FALSE); ?></td>
    <td>
        <?php echo $data->getElementValue('create_user_id'); ?>
        <br><?php echo $data->getElementValue('attorney_update_user_id'); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/calc_balance', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-calculator margin-r-5"></i> Пересчитать баланс</a></li>
        </ul>
    </td>
</tr>
