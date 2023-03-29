<table class="table table-hover table-db table-tr-line">
    <tr>
        <th rowspan="2">Карьер</th>
        <th colspan="2" class="text-center">День</th>
        <th colspan="2" class="text-center">Вчера</th>
        <th colspan="2" class="text-center">Неделя</th>
        <th colspan="2" class="text-center">Месяц</th>
        <th colspan="2" class="text-center">Прошлый месяц</th>
        <th colspan="2" class="text-center">Год</th>
    </tr>
    <tr>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
    </tr>
    <?php
    foreach ($data['view::_shop/ballast/one/statistics/quantity-count']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/ballast/one/statistics/quantity-count'];
    ?>
    <tr class="total">
        <td>Итого</td>
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
</table>

