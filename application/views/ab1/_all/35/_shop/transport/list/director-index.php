<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-40 text-right">№</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'transport_work_id.name'); ?>" class="link-black">Вид работ ТС</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'transport_view_id.name'); ?>" class="link-black">Вид транспорта</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Марка/гос.номер</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th class="width-90 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'is_trailer'); ?>" class="link-black">Прицеп</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_driver_id.name'); ?>" class="link-black">Осн. водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_fuel_storage_id.name'); ?>" class="link-black">Склад ГСМ</a>
        </th>
        <th class="text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'milage'); ?>" class="link-black">Пробег</a>
        </th>
        <th class="text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/day'). Func::getAddURLSortBy($siteData->urlParams, 'fuel_quantity'); ?>" class="link-black">Остаток ГСМ</a>
        </th>
        <th class="width-120"></th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/transport/one/director-index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
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

