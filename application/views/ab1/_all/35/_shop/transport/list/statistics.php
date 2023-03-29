<style>
    table tr:nth-child(1) th:nth-child(2n+3),
    table tr:nth-child(2) th:nth-child(1),
    table tr:nth-child(2) th:nth-child(2),
    table tr:nth-child(2) th:nth-child(3),
    table tr:nth-child(2) th:nth-child(7),
    table tr:nth-child(2) th:nth-child(8),
    table tr:nth-child(2) th:nth-child(11),
    table tr:nth-child(2) th:nth-child(12)
    {
        background-color: rgba(97, 206, 268, 0.6);
    }

    table tr:nth-child(1n+2) td:nth-child(3),
    table tr:nth-child(1n+2) td:nth-child(4),
    table tr:nth-child(1n+2) td:nth-child(5),
    table tr:nth-child(1n+2) td:nth-child(9),
    table tr:nth-child(1n+2) td:nth-child(10),
    table tr:nth-child(1n+2) td:nth-child(13),
    table tr:nth-child(1n+2) td:nth-child(14)
    {

        background-color: rgba(90, 216, 130, 0.7);
    }

</style>
<table class="table table-hover table-db table-tr-line" >

    <tr>
        <th rowspan="2"><a href="<?php echo Func::getFullURL($siteData, '/shoptransport/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'transport_view_id.name'); ?>">Вид транспорта</a></th>
        <th class="width-140 text-right" rowspan="2"><a href="<?php echo Func::getFullURL($siteData, '/shoptransport/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'count_all'); ?>">Количество ТС</a></th>
        <th colspan="3" class="text-center">Сегодня</th>
        <th colspan="3" class="text-center">Вчера</th>
        <th colspan="2" class="text-center">Неделя</th>
        <th colspan="2" class="text-center">Месяц</th>
        <th colspan="2" class="text-center">Прошлый месяц</th>
        <th colspan="2" class="text-center">Год</th>
    </tr>
    <tr>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
        <th class="width-80 text-right">В резерве</th>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
        <th class="width-80 text-right">В резерве</th>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
        <th class="width-80 text-right">На смене</th>
        <th class="width-85 text-right">В ремонте</th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/transport/one/statistics']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    $data = $data['view::_shop/transport/one/statistics'];
    ?>
    <tr class="total">
        <td class="text-right">Итого</td>
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
</table>

