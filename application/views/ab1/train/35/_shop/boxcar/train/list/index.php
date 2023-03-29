<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th style="width: 121px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Общий вес (т)</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_departure_station_id.name'); ?>" class="link-black">Станция отправления</a>
        </th>
        <th style="width: 125px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_shipment'); ?>" class="link-black">Дата отгрузки</a>
        </th>
        <th style="width: 125px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_departure'); ?>" class="link-black">Дата уборки</a>
        </th>
        <th style="width: 138px;">Вагоны</th>
        <th>Особые отметки</th>
        <th style="width: 140px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/boxcar/train/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
    $urlParams['page'] = '-pages-';

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

