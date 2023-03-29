<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th>Название</th>
        <th class="width-110">Ед. измерения</th>
        <th class="width-110 text-right">Сегодня</th>
        <th class="width-110 text-right">Вчера</th>
        <th class="width-110 text-right">Неделя</th>
        <th class="width-110 text-right">Месяц</th>
        <th class="width-110 text-right">Год</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/move/item/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/move/item/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
    </tr>
    </tbody>
</table>
