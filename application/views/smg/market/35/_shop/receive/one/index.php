<tr>
    <td class="text-center">
        <input <?php if ($data->values['is_check'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal" disabled>
        <input <?php if ($data->values['is_load_file'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal" disabled>
    </td>
    <td class="text-center">
        <input <?php if ($data->values['is_store'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal" disabled>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->getElementValue('shop_company_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right"><?php if($data->values['is_return'] == 1){ ?>-<?php } ?><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity']); ?></td>
    <td>
        <?php echo $data->values['esf_number']; ?>
        <?php if($data->values['is_return'] == 1){ ?>
            <br><b><a target="_blank" class="text-blue" href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array('id' => 'return_shop_receive_id'), array(), $data->values); ?>"><?php echo $data->getElementValue('return_shop_receive_id', 'esf_number'); ?></a></b>
        <?php } ?>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['esf_date']); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
