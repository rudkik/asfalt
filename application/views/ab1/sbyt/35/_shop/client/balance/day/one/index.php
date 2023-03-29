<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_client_id'); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['block_balance_client'], TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <?php if($data->values['block_amount'] > 0){ ?>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/balance_day', array(), array('shop_client_balance_day_id' => $data->id), $data->values); ?>"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></a>
        <?php }else{ ?>
            0.00
        <?php } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'], TRUE, 2, FALSE); ?></td>
</tr>
