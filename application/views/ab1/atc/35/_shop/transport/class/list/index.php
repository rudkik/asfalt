<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php Func::getFullURL($siteData, '/shoptransportclass/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Имя</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php Func::getFullURL($siteData, '/shoptransportclass/index'). Func::getAddURLSortBy($siteData->urlParams, 'percent'); ?>" class="link-black">Процент</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/class/one/index']->childs as $value) {
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

