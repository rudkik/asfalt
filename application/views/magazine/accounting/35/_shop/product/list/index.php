<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopproduct/save');?>">
            </span>
        </th>
        <th style="min-width: 70px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'barcode'); ?>" class="link-black">Штрихкод</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name_1c'); ?>" class="link-black">Название в 1С</a>
        </th>
        <th style="width: 33%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th style="min-width: 110px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Измерение</a>
        </th>
        <th class="text-right" style="min-width: 113px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Себестоимость</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/accounting/35/paginator');
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

