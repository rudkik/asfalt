<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_daughter_material', array('is_import_car' => 'is_import_car'), array('shop_branch_daughter_id' => $data->values['shop_branch_daughter_id'], 'shop_daughter_id' => $data->values['shop_daughter_id'], 'is_own' => Request_RequestParams::getParamInt('is_own'), 'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'))); ?>">
            <?php
            echo $data->getElementValue(
                'shop_branch_daughter_id',
                'name',
                $data->getElementValue(
                    'shop_daughter_id',
                    'name'
                )
            );
            ?>
        </a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>