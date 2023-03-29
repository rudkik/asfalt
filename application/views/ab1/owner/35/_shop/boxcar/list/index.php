<?php $isInTransit = Request_RequestParams::getParamBoolean('is_in_transit'); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Тоннаж</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ вагона</a>
        </th>
        <?php if(!$isInTransit){ ?>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_arrival'); ?>" class="link-black">Дата подачи</a>
            </th>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_drain_from'); ?>" class="link-black">Начало разгрузки</a>
            </th>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_drain_to'); ?>" class="link-black">Окончание разгрузки</a>
            </th>
        <?php } ?>
        <th>Станция нахождения</th>
    </tr>
    <?php
    foreach ($data['view::_shop/boxcar/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

