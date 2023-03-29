<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_daughter', array('is_import_car' => 'is_import_car'), array('is_own' => $data->getElementValue('shop_transport_company_id', 'is_own', 0), 'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'))); ?>">
            <?php if($data->getElementValue('shop_transport_company_id', 'is_own', 0) == 1){ ?>
                Собственные
            <?php }else{ ?>
                Наемные
            <?php } ?>
        </a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>
