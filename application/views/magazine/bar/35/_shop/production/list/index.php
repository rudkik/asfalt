<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopproduction/save');?>">
            </span>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'barcode'); ?>" class="link-black">Штрихкод</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Продукция</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_production_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th style="min-width: 110px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'unit_id.name'); ?>" class="link-black">Измерение</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'weight_kg'); ?>" class="link-black">Вес нетто</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'coefficient'); ?>" class="link-black">Коэффициент</a>
        </th>
        <th class="text-right width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Цена</a>
        </th>
        <th class="tr-header-line-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/production/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/bar/35/paginator');
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

