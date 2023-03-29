<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th class="width-30 text-right">№</th>
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
    $i = 1;
    foreach ($data['view::_shop/receive/one/statistics']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    $data = $data['view::_shop/receive/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="3">Итого</td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?></td>
    </tr>
    </tbody>
</table>
