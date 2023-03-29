<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopproduct/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Полное название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name_1c'); ?>" class="link-black">Название в 1С</a>
        </th>
        <th style="min-width: 140px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name_short'); ?>" class="link-black">Краткое название</a>
        </th>
        <th style="min-width: 110px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th style="min-width: 108px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_table_group_id.name'); ?>" class="link-black">Группа</a>
        </th>
        <th style="min-width: 168px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'product_type_id.name'); ?>" class="link-black">Тип / Вид</a>
        </th>
        <th class="width-105" style="font-size: 12px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_subdivision_id.name'); ?>" class="link-black">Подразделение / Склад</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Измерение</a>
        </th>
        <th class="text-right" style="min-width: 66px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
        </th>
        <th class="text-right" style="min-width: 66px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'order'); ?>" class="link-black">Сорт.</a>
        </th>
        <th class="width-115"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/one/index']->childs as $value) {
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

