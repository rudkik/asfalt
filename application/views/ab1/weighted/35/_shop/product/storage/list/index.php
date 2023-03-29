<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th style="width: 140px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_at'); ?>" class="link-black">Дата</a>
        </th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_storage_id.name'); ?>" class="link-black">Склад</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукция</a>
        </th>
        <th class="text-right" style="width: 90px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th style="width: 170px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место производство</a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'asu_operation_id.name'); ?>" class="link-black">Оператор АСУ</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th class="width-105 text-right" style="font-size: 14px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shopproductstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
            </th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/storage/one/index']->childs as $value) {
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

