<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_piece_id.created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_piece_id.name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-60 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th style="width: 260px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_formula_product_id.name'); ?>" class="link-black">Рецепт</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/piece/item/one/index']->childs as $value) {
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

