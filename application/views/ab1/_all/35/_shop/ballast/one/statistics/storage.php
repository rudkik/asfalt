<tr>
    <td>
        <?php echo $data->getElementValue('shop_id'); ?><br>
        <?php echo $data->getElementValue('shop_ballast_crusher_id', 'name', $data->getElementValue('take_shop_ballast_crusher_id')); ?><br>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['to'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_day'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_day'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_yesterday'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_yesterday'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_week'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_week'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_month'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_month'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_month_previous'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_month_previous'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['import_year'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['export_year'], TRUE, 0, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['to'], TRUE, 0, FALSE); ?></td>
</tr>
