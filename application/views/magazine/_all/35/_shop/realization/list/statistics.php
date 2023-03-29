<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th>Название</th>
        <th class="width-110">Ед. измерения</th>
        <th class="width-110 text-right">Сегодня</th>
        <th class="width-110 text-right">Вчера</th>
        <th class="width-110 text-right">Неделя</th>
        <th class="width-110 text-right">Месяц</th>
        <th class="width-110 text-right">Год</th>
    </tr>
    </thead>
    <tbody>
    <?php $cash = $data['view::_shop/realization/one/statistics']->additionDatas['cash']; ?>
    <tr style="background-color: rgba(97, 106, 168, 0.3);">
        <td><a href="<?php
            $arr = array(
                'shop_worker_id' => 0,
                'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
            );
            $arr['shop_branch_id'] = $siteData->shopID;
            echo Func::getFullURL($siteData, '/shoprealizationitem/statistics', array(), $arr, array(), true);
            ?>">Наличные</a></td>
        <td>тенге</td>
        <td style="text-align: right"><?php echo Func::getNumberStr($cash['amount_day'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($cash['amount_yesterday'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($cash['amount_week'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($cash['amount_month'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($cash['amount_year'], TRUE, 2, FALSE); ?></td>
    </tr>
    <?php
    foreach ($data['view::_shop/realization/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/realization/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?></td>
        <td style="text-align: right"><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?></td>
    </tr>
    </tbody>
</table>
