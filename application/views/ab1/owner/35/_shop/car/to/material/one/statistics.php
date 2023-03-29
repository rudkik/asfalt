<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopdaughter/statistics', array('is_import_car' => 'is_import_car'), array('daughter_id' => $data->values['shop_branch_daughter_id'] + $data->values['shop_daughter_id'], 'shop_branch_id' => $siteData->shopID)); ?>">
            <?php
            $s = $data->getElementValue('shop_daughter_id');
            if(empty($s)){
                $s = $data->getElementValue('shop_branch_daughter_id');
            }
            echo $s;
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
