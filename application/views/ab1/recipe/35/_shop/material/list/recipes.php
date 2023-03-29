<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterial/recipes'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Материал</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterial/recipes'). Func::getAddURLSortBy($siteData->urlParams, 'name_recipe'); ?>" class="link-black">Название рецепта</a>
        </th>
        <th style="width: 160px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterial/recipes'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterial/recipes'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Измерение</a>
        </th>
        <th class="width-105"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/material/one/recipes']->childs as $value) {
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

