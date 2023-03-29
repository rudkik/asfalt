<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма оплаты</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'block_balance_client'); ?>" class="link-black">Долг</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'block_amount'); ?>" class="link-black">Израсходовано</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientbalanceday/index'). Func::getAddURLSortBy($siteData->urlParams, 'balance'); ?>" class="link-black">Остаток</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/balance/day/one/index']->childs as $value) {
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

