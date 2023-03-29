<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcashbox/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcashbox/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcashbox/index'). Func::getAddURLSortBy($siteData->urlParams, 'ip'); ?>" class="link-black">IP</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcashbox/index'). Func::getAddURLSortBy($siteData->urlParams, 'port'); ?>" class="link-black">Порт</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcashbox/index'). Func::getAddURLSortBy($siteData->urlParams, 'symbol'); ?>" class="link-black">Символ</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/cashbox/one/index']->childs as $value) {
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

