<tr>
    <td><a href="<?php
        $arr = array(
            'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'),
            'is_charity' => true,
            'shop_client_id' => $data->values['shop_client_id'],
        );
        echo Func::getFullURL($siteData, '/shopproduct/statistics', array(), $arr);
        ?>"><?php echo $data->getElementValue('shop_client_id'); ?></a></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>
