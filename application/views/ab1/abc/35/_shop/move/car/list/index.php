<table class="table table-hover table-db table-tr-line" style="min-width: 1373px;">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_entry_at'); ?>" class="link-black">Дата въезда</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_at'); ?>" class="link-black">Дата выезда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th class="width-60 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'tarra'); ?>" class="link-black">Тара</a>
        </th>
        <th class="width-60 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th style="width: 230px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_formula_product_id.name'); ?>" class="link-black">Рецепт</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th class="width-140">
                <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'cash_operation_id.name'); ?>" class="link-black">Оператор</a>
            </th>
        <?php } ?>
    </tr>
    <?php
    foreach ($data['view::_shop/move/car/one/index']->childs as $value) {
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

