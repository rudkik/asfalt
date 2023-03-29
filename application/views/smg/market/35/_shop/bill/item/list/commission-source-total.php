<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th rowspan="2" class="text-right width-40">№</th>
        <th rowspan="2" class="width-70">Фото</th>
        <th rowspan="2">Название</th>
        <th rowspan="2" class="width-90">№ заказа</th>
        <th rowspan="2" class="text-right width-65">Кол-во</th>
        <th rowspan="2" class="text-right width-80">Цена</th>
        <th rowspan="2" class="text-right width-100">Сумма</th>
        <th colspan="2" class="text-center">Коммисия источника</th>
    </tr>
    <tr>
        <th class="text-right width-100">%</th>
        <th class="text-right width-100">тг</th>
    </tr>
    </thead>
    <tbody>
    <tr class="bg-blue">
        <td colspan="4" class="text-right">Итого:</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_bill_items'], true); ?></td>
        <td class="text-right">x</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['amount_bill_items'], true); ?></td>
        <td class="text-right">x</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['commission_source'], true, 2, false); ?></td>
    </tr>
    <?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/commission-source']); ?>
    <tr class="bg-blue">
        <td colspan="4" class="text-right">Итого:</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_bill_items'], true); ?></td>
        <td class="text-right">x</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['amount_bill_items'], true); ?></td>
        <td class="text-right">x</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['commission_source'], true, 2, false); ?></td>
    </tr>
    </tbody>
</table>