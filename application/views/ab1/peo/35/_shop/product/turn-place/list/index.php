<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopproductturnplace/save');?>">
            </span>
        </th>
        <th style="min-width: 110px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductturnplace/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место производства</a>
        </th>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductturnplace/index'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Дата от</a>
        </th>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductturnplace/index'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Дата до</a>
        </th>
        <th class="width-115"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/turn-place/one/index']->childs as $value) {
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

