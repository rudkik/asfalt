<table class="table table-hover table-db table-tr-line" style="min-width: 1373px;">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/formula'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/formula'). Func::getAddURLSortBy($siteData->urlParams, 'shop_formula_product_id.name'); ?>" class="link-black">Рецепт</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/formula'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/formula'). Func::getAddURLSortBy($siteData->urlParams, 'count'); ?>" class="link-black">Кол-во машин</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/formula']->childs as $value) {
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

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id') );
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

