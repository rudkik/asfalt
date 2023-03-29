<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th>Название</th>
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
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/realization/write-off/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/realization/write-off/one/statistics'];
    ?>
    <tr class="total">
        <td>Итого</td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['1'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['1'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['2'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['2'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['3'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['3'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['4'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['4'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['5'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['5'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['6'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['6'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['7'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['7'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['8'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['8'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['9'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['9'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['10'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['10'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['11'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['11'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity']['12'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount']['12'], TRUE, 2, FALSE); ?>
        </td>
    </tr>
    </tbody>
</table>
