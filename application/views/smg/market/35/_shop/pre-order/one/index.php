<tr>
    <td class="text-center">
        <input <?php if ($data->values['is_check'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal" disabled>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_courier_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_address_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
