<tr>
    <td class="text-right">#index#</td>
    <?php if(Request_RequestParams::getParamBoolean('is_balance')){ ?>
        <td>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/statistics', array(), array('shop_client_id' => $data->values['shop_client_id'], 'shop_client_name' => $data->getElementValue('shop_client_id'), 'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'))); ?>">
                <?php echo $data->getElementValue('shop_client_id'); ?>
            </a>
            <?php if(Arr::path($data->additionDatas, 'is_supplier') == true){ ?>
                <br><span style="font-size: 18px;" class="text-green">поставщик</span>
            <?php  } ?>
        </td>
    <?php }?>
    <td class="text-right">
        <?php
        echo Func::getNumberStr($data->getElementValue('shop_client_id', 'balance'), TRUE, 2, FALSE);

        $territory = Arr::path($data->additionDatas, 'territory');
        if($territory > 0){
            ?>
            <br><span style="font-size: 18px;" class="text-red">на территории <?php echo Func::getNumberStr($territory, TRUE, 2, FALSE); ?></span>
        <?php  } ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
</tr>
