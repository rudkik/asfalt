<table class="table table-hover table-db table-tr-line">
    <tr>
        <th rowspan="2">Карьер #shop#</th>
        <th colspan="3" class="text-center">День</th>
        <th colspan="3" class="text-center">Вчера</th>
        <th rowspan="2" class="text-right width-70">Неделя</th>
        <th rowspan="2" class="text-right width-70">Месяц</th>
        <th rowspan="2" class="text-right width-80">Прошлый месяц</th>
        <th rowspan="2" class="text-right width-70">Год</th>
    </tr>
    <tr>
        <th class="text-center">Первый рейс</th>
        <th class="text-center">Крайний рейс</th>
        <th class="text-right width-70">Вес</th>
        <th class="text-center">Первый рейс</th>
        <th class="text-center">Крайний рейс</th>
        <th class="text-right width-70">Вес</th>
    </tr>
    <?php
    foreach ($data['view::_shop/ballast/one/statistics/quantity']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/ballast/one/statistics/quantity'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td class="text-center"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['min_date_day']); ?></td>
        <td class="text-center"><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['max_date_day']); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 0, FALSE); ?></td>
        <td><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['min_date_yesterday']); ?></td>
        <td><?php echo Helpers_DateTime::getTimeFormatRus($data->additionDatas['max_date_yesterday']); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 0, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 0, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 0, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 0, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 0, FALSE); ?></td>
    </tr>
</table>

