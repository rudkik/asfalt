<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="text-right width-100">
            Начало года
        </th>
        <th class="text-right width-100">
            Текущий номер
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_id.name'); ?>" class="link-black">Филиал</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'symbol'); ?>" class="link-black">Префикс</a>
        </th>
        <th class="width-65">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'length'); ?>" class="link-black">Длина</a>
        </th>
        <th class="width-95">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_branch'); ?>" class="link-black">У филиала</a>
        </th>
        <th class="width-110 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_cashbox'); ?>" class="link-black">У кассового аппарата</a>
        </th>
        <th class="width-110 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_product'); ?>" class="link-black">У продукции / материала</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsequence/index'). Func::getAddURLSortBy($siteData->urlParams, 'table_id.name'); ?>" class="link-black">Таблица</a>
        </th>
        <th class="width-150">
            Название счетчика
        </th>
        <th class="width-120"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/sequence/one/index']->childs as $value) {
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
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>