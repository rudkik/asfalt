<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_daughter_id.name'); ?>" class="link-black">Отправитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_receiver_id.name'); ?>" class="link-black">Получатель</a>
        </th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="tr-header-price">Брутто</th>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'tarra'); ?>" class="link-black">Тара</a>
        </th>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th style="width: 140px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_daughter'); ?>" class="link-black">Вес отправителя</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th style="width: 131px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_operation_id.name'); ?>" class="link-black">Оператор</a>
            </th>
        <?php } ?>
        <th style="width: 140px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/to/material/one/index']->childs as $value) {
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

