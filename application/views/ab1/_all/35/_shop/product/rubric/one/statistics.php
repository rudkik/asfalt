<tr>
    <td><a href="<?php
        $arr = array(
            'shop_product_rubric_id' => $data->values['id'],
            'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'),
        );

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        if($shopClientID !== NULL){
            $arr['shop_client_id'] = $shopClientID;
            $arr['shop_client_name'] = Request_RequestParams::getParamStr('shop_client_name');
        }
        echo Func::getFullURL($siteData, '/shopproduct/statistics', array(), $arr);
        ?>"><?php echo $data->values['name']; ?></a></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>
