<tr>
    <td class="text-center">
        <input name="set-is-public" <?php if ($data->values['is_buyer'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopclient/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>" data-field="is_buyer">
    </td>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['bin']; ?></td>
    <td class="text-right">
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/money_type', array('shop_client_id' => 'id'), array('is_cash' => true), $data->values); ?>" class="link-blue">
            <?php echo Func::getNumberStr($data->values['balance_cache'],TRUE, 2, FALSE); ?>
        </a>
    </td>
    <td class="text-right">
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/money_type', array('shop_client_id' => 'id'), array('is_cash' => false), $data->values); ?>" class="link-blue">
            <?php echo Func::getNumberStr($data->values['balance'],TRUE, 2, FALSE); ?>
        </a>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/calc_balance', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-calculator margin-r-5"></i> Пересчитать баланс</a></li>
        </ul>
    </td>
</tr>
