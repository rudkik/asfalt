<tr>
    <td><?php echo $data->getElementValue('shop_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_day'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_yesterday'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_week'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_month'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_month_previous'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_year'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 0, FALSE); ?></td>
</tr>
