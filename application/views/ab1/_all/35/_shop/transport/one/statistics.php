<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/director_index', [],
            array(
                    'shop_transport_mark_id/transport_view_id' => $data->getElementValue('shop_transport_mark_id', 'transport_view_id'),
                    'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'),
            )); ?>">
            <?php echo $data->getElementValue('transport_view_id'); ?>
        </a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_all'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_day'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_day'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo $data->additionDatas['count_all'] - $data->additionDatas['count_day'] - $data->additionDatas['repair_day']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_yesterday'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_yesterday'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo $data->additionDatas['count_all'] - $data->additionDatas['count_yesterday'] - $data->additionDatas['repair_yesterday']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_week'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_week'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_month'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_month'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_month_previous'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_month_previous'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count_year'], TRUE, 0); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['repair_year'], TRUE, 0); ?></td>
</tr>
