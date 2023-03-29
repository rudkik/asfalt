<tr>
    <td>
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_esf', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td>
        <?php
        if(!empty($data->values['date'])){
            echo Helpers_DateTime::getDateFormatRus($data->values['date']);
        }else {
            echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']);
        }
        ?>
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right"><?php echo $data->values['quantity']; ?></td>
    <td class="text-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreturn/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreturn/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopreturn/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopreturn/esf', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Загрузить ЭСФ</a></li>
        </ul>
    </td>
</tr>
