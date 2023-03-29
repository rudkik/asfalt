<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Материал</th>
        <th class="width-100 text-right">Сегодня (т)</th>
        <th class="width-100 text-right">Вчера (т)</th>
        <th class="width-100 text-right">Неделя (т)</th>
        <th class="width-100 text-right">Месяц (т)</th>
        <th class="width-100 text-right">Прошлый месяц (т)</th>
        <th class="width-100 text-right">Год (т)</th>
    </tr>
    <?php
    foreach ($data['view::_shop/daughter/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/daughter/one/statistics'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
    </tr>

</table>

