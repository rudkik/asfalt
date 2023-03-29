<table class="table table-hover table-db table-tr-line" >
    <thead>
        <tr>
            <th>Клиент</th>
            <th class="width-240">Поставщик</th>
            <th>Сырье</th>
            <th class="width-60 text-right">Кол-во вагонов</th>
            <th class="width-90 text-right">Тоннаж</th>
            <th class="width-120">Дата подачи</th>
            <th class="width-138">Начало разгрузки</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['view::_shop/boxcar/one/unload-lessee']->childs as $value) {
            echo $value->str;
        }
        $data = $data['view::_shop/boxcar/one/unload-lessee'];
        ?>
        <tr class="total">
            <td colspan="3" class="text-right">Итого</td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count'], TRUE, 0, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
        </tr>
    </tbody>
</table>

