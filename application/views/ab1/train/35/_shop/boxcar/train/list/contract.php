<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'paid_quantity'); ?>" class="link-black">Оплачено (т)</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'received_quantity'); ?>" class="link-black">Получено (т)</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'in_way_quantity'); ?>" class="link-black">В пути (т)</a>
        </th>
        <th class="width-130 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'balance_quantity'); ?>" class="link-black">Не отгружено (т)</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/boxcar/train/one/contract']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

