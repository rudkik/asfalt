<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2" class="text-right" style="width: 40px; ">№</th>
        <th rowspan="2">Клиент</th>
        <th rowspan="2">Продукт</th>
        <th colspan="2" class="text-center">Остатки</th>
    </tr>
    <tr>
        <th class="width-120 text-right">На начало года</th>
        <th class="width-130 text-right">На текущий момент</th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/lessee/car/one/statistics-total']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    $data = $data['view::_shop/lessee/car/one/statistics-total'];
    ?>
    <tr class="total">
        <td colspan="3" class="text-right">Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
    </tr>
</table>

