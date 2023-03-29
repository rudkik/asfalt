<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php Func::getFullURL($siteData, '/shopcashboxterminal/save');?>">
            </span>
        </th>
        <th class="width-70">
            <a href="<?php Func::getFullURL($siteData, '/shopcashboxterminal/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th class="width">
            <a href="<?php Func::getFullURL($siteData, '/shopcashboxterminal/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>

        <th class="tr-header-buttom"></th>
    </tr>
    <?php    foreach ($data['view::_shop/cashbox/terminal/one/index']->childs as $value) {
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

