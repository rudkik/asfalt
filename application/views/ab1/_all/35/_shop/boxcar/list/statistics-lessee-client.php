<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th rowspan="2">Клиент</th>
        <th rowspan="2">Сырье</th>
        <th class="text-center" colspan="2">Приход</th>
    </tr>
    <tr>
        <th class="text-right width-110">С начала года</th>
        <th class="text-right width-110">За всё время</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/boxcar/one/statistics-lessee-client']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/boxcar/one/statistics-lessee-client'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
    </tr>
    </tbody>
</table>

