<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoptransport/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_mark_id.name'); ?>" class="link-black">Марка + Гос. номер</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_storage_id.name'); ?>" class="link-black">Склад ГСМ</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_driver_id.name'); ?>" class="link-black">Основной водитель</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_trailer'); ?>" class="link-black">Прицеп</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransport/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_storage_id.name'); ?>" class="link-black">Гараж</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/one/index']->childs as $value) {
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

