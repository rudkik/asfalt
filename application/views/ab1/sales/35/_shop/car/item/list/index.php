<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th class="width-40">№</th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_car_id.created_at'); ?>" class="link-black">Дата выезда</a>
        </th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_car_id.name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-105"></th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/car/item/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
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

