<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th rowspan="2">Название</th>
        <th colspan="6" class="text-right">Количество в условных единицах</th>
    </tr>
    <tr>
        <th class="width-100 text-right">Сегодня</th>
        <th class="width-100 text-right">Вчера</th>
        <th class="width-100 text-right">Неделя</th>
        <th class="width-100 text-right">Месяц</th>
        <th class="width-100 text-right">Прошлый месяц</th>
        <th class="width-100 text-right">Год</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/product/storage/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/product/storage/one/statistics'];
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
    </tbody>
</table>

