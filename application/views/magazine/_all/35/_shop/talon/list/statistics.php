<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th>Месяц выдачи молока</th>
        <th class="width-110">Ед. измерения</th>
        <th class="width-110 text-right">Начислено талонов</th>
        <th class="width-110 text-right">Отоварено талонов</th>
        <th class="width-110 text-right">Не отоварено талонов (остаток)</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/talon/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/talon/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_spent'], TRUE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_spent'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity'] - $data->additionDatas['quantity_spent'], TRUE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount'] - $data->additionDatas['amount_spent'], TRUE, 2, FALSE); ?>
        </td>
    </tr>
    </tbody>
</table>
