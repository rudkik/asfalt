<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td>
        <?php
        if($data->values['shop_client_contract_id'] > 0){
            echo $data->getElementValue('shop_client_contract_id', 'number') . ' от '. Helpers_DateTime::getDateTimeDayMonthRus($data->getElementValue('shop_client_contract_id', 'from_at'), TRUE);
        }else{
            echo 'Без договора';
        }
        ?>
    </td>
    <td class="text-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/edit', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/clone', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/del', array('id' => 'id'), array(), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/del', array('id' => 'id'), array('is_undel' => 1), $data->values, false, false, true); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
