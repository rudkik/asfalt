<tr>
    <td><?php echo $data->getElementValue('shop_ballast_crusher_id'); ?></td>
    <td class="text-center text-blue"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['min_date_day']); ?></td>
    <td class="text-center text-blue"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['max_date_day']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 0, FALSE); ?></td>
    <td class="text-center text-blue"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['min_date_yesterday']); ?></td>
    <td class="text-center text-blue"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['max_date_yesterday']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 0, FALSE); ?></td>
</tr>
