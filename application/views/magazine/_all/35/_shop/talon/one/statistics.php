<tr>
    <td>
        <a href="<?php
        $arr = array(
            'validity_from' => $data->values['validity_from'],
            'validity_to' => $data->values['validity_to'],
            'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
        );
        $arr['shop_branch_id'] = $siteData->shopID;
        echo Func::getFullURL($siteData, '/shopworker/statistics', array(), $arr, array(), true);
        ?>">
            <?php echo Helpers_DateTime::getPeriodRus($data->values['validity_from'], $data->values['validity_to'], false); ?>
        </a>
    </td>
    <td>
        талон
        <br>тенге
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->values['quantity'], TRUE); ?>
        <br><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->values['quantity_spent'], TRUE); ?>
        <br><?php echo Func::getNumberStr($data->values['amount_spent'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->values['quantity'] - $data->values['quantity_spent'], TRUE); ?>
        <br><?php echo Func::getNumberStr($data->values['amount'] - $data->values['amount_spent'], TRUE, 2, FALSE); ?>
    </td>
</tr>
