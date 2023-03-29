<table class="table table-hover table-db table-tr-line" style="min-width: 1373px;" data-action="fixed">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_at'); ?>" class="link-black">Дата выезда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Место вывоза</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'tarra'); ?>" class="link-black">Тара</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_operation_id.name'); ?>" class="link-black">Оператор</a>
            </th>
            <th class="width-105 text-right" style="font-size: 14px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shopmoveother/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
            </th>
        <?php } ?>
        <th style="width: 143px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/move/other/one/index']->childs as $value) {
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

