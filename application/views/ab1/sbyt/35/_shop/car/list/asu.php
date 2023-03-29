<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th style="width: 135px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/asu'). Func::getAddURLSortBy($siteData->urlParams, 'cash_operation_id.name'); ?>" class="link-black">Оператор</a>
        </th>
        <th class="width-105"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/asu']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

