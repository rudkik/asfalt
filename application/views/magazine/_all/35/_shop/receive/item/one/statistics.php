<tr>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('unit_id'); ?>
        <br>тенге
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
    </td>
</tr>
