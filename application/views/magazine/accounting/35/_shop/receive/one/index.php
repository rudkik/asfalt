<tr <?php if($data->values['is_esf'] != 1 && strtotime(Helpers_DateTime::plusDays($data->values['created_at'], 10)) < time()){ ?>class="b-red"<?php } ?>>
    <td>
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_esf', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td>
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_nds', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->getElementValue('esf_type_id'); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopsupplier/edit', array(), array('id' => $data->values['shop_supplier_id']), $data->values); ?>" target="_blank"><?php echo $data->getElementValue('shop_supplier_id'); ?></a>
        <br><?php echo $data->getElementValue('shop_supplier_id', 'bin'); ?>
    </td>
    <td class="text-right"><?php echo $data->values['quantity']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/esf', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-paw margin-r-5"></i> Загрузить ЭСФ</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/production', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-cubes margin-r-5"></i> Продукция</a></li>
        </ul>
    </td>
</tr>
