<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">  Подразделение
        </th>
        <th colspan="6" class="text-right">Количество в условных единицах</th>
    </tr>
    <tr>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_day'); ?>" class="link-black">Сегодня</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_yesterday'); ?>" class="link-black">Вчера</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_week'); ?>" class="link-black">Неделя</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month'); ?>" class="link-black">Месяц</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month_previous'); ?>" class="link-black">Прошлый месяц</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/charity_statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_year'); ?>" class="link-black">Год</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/one/charity']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/client/one/charity'];
    ?>
    <tr class="total">
        <td class="text-right">Итого</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
    </tr>
</table>

