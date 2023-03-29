<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th class="width-95">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_buyer'); ?>" class="link-black">Покупатель</a>
        </th>
        <th class="width-65">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'bin'); ?>" class="link-black">БИН/ИИН</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'balance_cache'); ?>" class="link-black">Наличные</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'). Func::getAddURLSortBy($siteData->urlParams, 'balance'); ?>" class="link-black">Баланс</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/one/index']->childs as $value) {
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