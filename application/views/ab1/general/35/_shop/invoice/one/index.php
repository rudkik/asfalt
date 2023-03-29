<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_client_attorney_id', 'number'); ?></td>
    <td><?php echo $data->getElementValue('shop_client_contract_id', 'number', 'без договора'); ?></td>
    <td><?php echo $data->getElementValue('product_type_id'); ?></td>
    <td><?php if($data->values['shop_client_attorney_id'] > 0){echo 'безналичный';}else{echo 'наличный';} ?></td>
    <td><?php if($data->values['is_delivery'] == 1){echo 'с доставкой';}else{echo 'без доставки';} ?></td>
    <td><?php echo $data->getElementValue('check_type_id', 'name', 'Не проверено'); ?></td>
    <td><?php echo $data->getElementValue('shop_id'); ?></td>
    <?php if(!Request_RequestParams::getParamBoolean('is_send_esf')){?>
        <td class="text-right"><?php echo Helpers_DateTime::diffTimeRUS(Helpers_DateTime::plusDays($data->values['date'].' 06:00:00', 10), date('Y-m-d H:i:d')); ?></td>
    <?php }?>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['id'], 'is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
