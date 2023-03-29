<table class="table table-hover table-db table-tr-line" style="margin-top: 40px">
    <tr>
        <th rowspan="2">Штабель</th>
        <th rowspan="2" class="text-right">Остаток на<br> начало года</th>
        <th colspan="2" class="text-center">День</th>
        <th colspan="2" class="text-center">Вчера</th>
        <th colspan="2" class="text-center">Неделя</th>
        <th colspan="2" class="text-center">Месяц</th>
        <th colspan="2" class="text-center">Прошлый месяц</th>
        <th colspan="2" class="text-center">Год</th>
        <th rowspan="2" class="text-right">Текущий<br> остаток</th>
    </tr>
    <tr>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
        <th class="text-right">Завоз</th>
        <th class="text-right">Вывоз</th>
    </tr>
    <?php
    foreach ($data['view::_shop/ballast/one/statistics/storage']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/ballast/one/statistics/storage'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['from'], TRUE, 0, FALSE); ?></td>
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
</table>

