<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>">Транспорт</a></th>
        <th><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_driver_id.name'); ?>">Водитель</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_day'); ?>">Сегодня</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_yesterday'); ?>">Вчера</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_week'); ?>">Неделя</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month'); ?>">Месяц</a></th>
        <th class="width-130 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month_previous'); ?>">Прошлый месяц</a></th>
        <th class="width-100 text-right"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_year'); ?>">Год</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/transport/waybill/fuel/expense/one/statistics']->childs as $value) {
        echo $value->str;
    }
    $data = $data['view::_shop/transport/waybill/fuel/expense/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2">Итого</td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3); ?>
        </td>
        <td class="text-right">
            <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3); ?>
        </td>
    </tr>
    </tbody>
</table>

