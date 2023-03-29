<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th>Название</th>
        <th class="width-120 text-right">Сегодня</th>
        <th class="width-120 text-right">Вчера</th>
        <th class="width-120 text-right">Неделя</th>
        <th class="width-120 text-right">Месяц</th>
        <th class="width-120 text-right">Прошлый месяц</th>
        <th class="width-120 text-right">Год</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/delivery/one/statistics/client']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/delivery/one/statistics/client'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_month_previous'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
        </td>
    </tr>
    </tbody>
</table>

