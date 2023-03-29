<tr>
    <td><?php echo $data->getElementValue('shop_production_id'); ?></td>
    <td><?php echo $data->getElementValue('unit_id'); ?></td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
    </td>
</tr>
