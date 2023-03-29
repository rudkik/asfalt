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
    <td><?php echo $data->getElementValue('create_user_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
