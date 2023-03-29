<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th>Название</th>
        <th class="width-120 text-right">Сегодня</th>
        <th class="width-120 text-right">Вчера</th>
        <th class="width-120 text-right">Неделя</th>
        <th class="width-120 text-right">Месяц</th>
        <th class="width-120 text-right">Прошлый месяц</th>
        <th class="width-120 text-right">Год</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/turn/place/one/statistics-car']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/turn/place/one/statistics-car'];
    ?>
    <tr class="total">
        <td colspan="1">Итого</td>
        <?php if($data->additionDatas['is_volume']){?>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_day'], TRUE, 3, true); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_yesterday'], TRUE, 3, true); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_week'], TRUE, 3, true); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_month'], TRUE, 3, true); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_month_previous'], TRUE, 3, true); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?> / <?php echo Func::getNumberStr($data->additionDatas['volume']['quantity_year'], TRUE, 3, true); ?></td>
        <?php }else{?>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
        <?php }?>
    </tr>
    </tbody>
</table>
