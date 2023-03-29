<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopraw/recipe'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Продукция</a>
        </th>
        <th class="width-80 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopraw/recipe'). Func::getAddURLSortBy($siteData->urlParams, 'count_recipe'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="width-105"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/raw/one/recipe']->childs as $value) {
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

