<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ письма</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Дата начала</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Дата окончания</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-70">Файл</th>
        <th style="width: 240px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/guarantee/one/index']->childs as $value) {
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

