<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2">Название</th>
        <th colspan="12" class="text-right">Количество в условных единицах</th>
    </tr>
    <tr>
        <th class="text-right">Январь</th>
        <th class="text-right">Февраль</th>
        <th class="text-right">Март</th>
        <th class="text-right">Апрель</th>
        <th class="text-right">Май</th>
        <th class="text-right">Июнь</th>
        <th class="text-right">Июль</th>
        <th class="text-right">Август</th>
        <th class="text-right">Сентябрь</th>
        <th class="text-right">Октябрь</th>
        <th class="text-right">Ноябрь</th>
        <th class="text-right">Декабрь</th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/rubric/one/statistics-year']->childs as $value) {
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

