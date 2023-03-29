<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="">
            <a href="<?php Func::getFullURL($siteData, '/shopclientchangemoneytype/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_cash'); ?>" class="link-black">Перевод</a>
        </th>
        <th class="width-180">
            <a href="<?php Func::getFullURL($siteData, '/shopclientchangemoneytype/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width">
            <a href="<?php Func::getFullURL($siteData, '/shopclientchangemoneytype/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Описание</a>
        </th>
        <th class="width-100">
            <a href="<?php Func::getFullURL($siteData, '/shopclientchangemoneytype/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php    foreach ($data['view::_shop/client/change-money-type/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<div class="col-md-12 padding-top-5px">
    <?php    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $siteData->urlParams;
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

