<tr>
    <td><a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/statistics', array(), array('shop_client_id' => $data->values['shop_client_id'], 'shop_client_name' => $data->getElementValue('shop_client_id'), 'shop_branch_id' => $siteData->shopID)); ?>"><?php echo $data->getElementValue('shop_client_id'); ?></a></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_client_id', 'amount') - $data->getElementValue('shop_client_id', 'block_amount'), TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>
