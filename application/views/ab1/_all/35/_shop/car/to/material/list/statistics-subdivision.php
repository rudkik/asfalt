<table class="table table-hover table-db table-tr-line" style="margin-bottom: 40px;">
    <tr>
        <th><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id'); ?>" class="link-black">Материал</a></th>
        <th><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'shop_subdivision_daughter_id'); ?>" class="link-black">Откуда</a></th>
        <th><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'shop_subdivision_receiver_id'); ?>" class="link-black">Куда</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_day'); ?>" class="link-black">Сегодня (т)</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_yesterday'); ?>" class="link-black">Вчера (т)</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_week'); ?>" class="link-black">Неделя (т)</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month'); ?>" class="link-black">Месяц (т)</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month_previous'); ?>" class="link-black">Прошлый месяц (т)</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/statistics_subdivision'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_year'); ?>" class="link-black">Год (т)</a></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/to/material/one/statistics-subdivision']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/car/to/material/one/statistics-subdivision'];
    ?>
    <tr class="total">
        <td colspan="3">Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
    </tr>
</table>

