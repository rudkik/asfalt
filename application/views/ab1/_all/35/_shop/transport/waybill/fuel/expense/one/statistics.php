<tr>
    <td>
        <?php echo $data->getElementValue('shop_transport_id'); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_driver_id'); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3); ?>
    </td>
</tr>
