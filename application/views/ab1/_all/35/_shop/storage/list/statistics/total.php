<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th>Склад</th>
        <th class="text-right width-110">Остаток (т)</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/storage/one/statistics/total']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/storage/one/statistics/total'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
    </tr>
    </tbody>
</table>

