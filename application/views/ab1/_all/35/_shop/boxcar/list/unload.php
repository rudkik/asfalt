<table class="table table-hover table-db table-tr-line" >
    <thead>
        <tr>
            <th class="width-240">Поставщик</th>
            <th>Сырье</th>
            <th class="width-60 text-right">Кол-во вагонов</th>
            <th class="width-90 text-right">Тоннаж</th>
            <th class="width-120">
                <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'date_arrival'); ?>" >Дата подачи</a>
            </th>
            <th class="width-138">Начало разгрузки</th>
            <th class="width-138">Окончание разгрузки</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['view::_shop/boxcar/one/unload']->childs as $value) {
            echo $value->str;
        }
        $data = $data['view::_shop/boxcar/one/unload'];
        ?>
        <tr class="total">
            <td colspan="2" class="text-right">Итого</td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['count'], TRUE, 0, FALSE); ?></td>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
            <td class="text-right" colspan="3"></td>
        </tr>
    </tbody>
</table>

