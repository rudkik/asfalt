<table class="table table-hover table-db table-tr-line">
    <thead>
    <tr>
        <th class="width-30 text-right">№</th>
        <th>Название</th>
        <th class="width-140">Ед. измерения</th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealizationitem/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'amount_day'); ?>" class="link-black">Сегодня</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealizationitem/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'amount_yesterday'); ?>" class="link-black">Вчера</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealizationitem/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'amount_week'); ?>" class="link-black">Неделя</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealizationitem/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'amount_month'); ?>" class="link-black">Месяц</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprealizationitem/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'amount_year'); ?>" class="link-black">Год</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($data['view::_shop/realization/item/one/statistics']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    $data = $data['view::_shop/realization/item/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="3">Итого</td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
        </td>
        <td style="text-align: right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
            <br><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
        </td>
    </tr>
    </tbody>
</table>
