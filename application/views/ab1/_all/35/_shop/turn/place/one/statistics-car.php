<?php $volume = $data->getElementValue('shop_product_id', 'volume', 1);?>
<tr>
    <td>
        <?php echo $data->values['name']; ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>         
            / <?php echo Func::getNumberStr($data->additionDatas['quantity_day'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>
        / <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>
        / <?php echo Func::getNumberStr($data->additionDatas['quantity_week'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>
        / <?php echo Func::getNumberStr($data->additionDatas['quantity_month'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>
        / <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
        <?php if($volume != 1){?>
        / <?php echo Func::getNumberStr($data->additionDatas['quantity_year'] / $volume, TRUE, 3, true); ?>
        <?php } ?>
    </td>
</tr>
