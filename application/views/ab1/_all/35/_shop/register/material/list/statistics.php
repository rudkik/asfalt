<table class="table table-hover table-db table-tr-line" >
<thead>
    <tr>
        <th>Материал</th>
        <th class="width-120">Подразделение</th>
        <th class="width-100 text-right">Остаток (т)</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/register/material/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/register/material/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
    </tr>
    </tbody>
</table>

