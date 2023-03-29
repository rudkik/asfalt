<table class="table table-hover table-db table-tr-line" style="min-width: 1373px;" data-action="fixed">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th style="width: 100px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th style="width: 100px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_entry_at'); ?>" class="link-black">Дата въезда</a>
        </th>
        <th style="width: 100px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_at'); ?>" class="link-black">Дата выезда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th style="width: 79px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'tarra'); ?>" class="link-black">Тара</a>
        </th>
        <th style="width: 79px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th style="width: 131px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_operation_id.name'); ?>" class="link-black">Оператор</a>
            </th>
            <th class="width-105 text-right" style="font-size: 14px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
            </th>
        <?php } ?>
        <th style="width: 196px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/lessee/car/one/index']->childs as $value) {
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

