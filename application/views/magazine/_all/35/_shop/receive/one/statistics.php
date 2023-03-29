<tr>
    <td class="text-right">#index#</td>
    <td><a href="<?php
        $arr = array(
            'shop_supplier_id' => $data->values['shop_supplier_id'],
            'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
        );
        $arr['shop_branch_id'] = $siteData->shopID;
        echo Func::getFullURL($siteData, '/shopreceiveitem/statistics', array(), $arr, array(), true);
        ?>"><?php echo $data->getElementValue('shop_supplier_id'); ?></a></td>
    <td>тенге</td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
    </td>
</tr>
