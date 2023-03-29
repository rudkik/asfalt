<tr>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td><?php echo $data->getElementValue('unit_id'); ?> / тенге</td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
    </td>
</tr>
