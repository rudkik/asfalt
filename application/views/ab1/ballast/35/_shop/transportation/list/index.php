<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_ballast_car_name'); ?>" class="link-black">№ машины</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_ballast_driver_name'); ?>" class="link-black">Водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_ballast_distance_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_work_shift_id.name'); ?>" class="link-black">Смена</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_ballast_crusher_id.name'); ?>" class="link-black">Место выгрузки</a>
        </th>
        <th class="width-80 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'flight'); ?>" class="link-black">Рейсов</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <th class="width-105 text-right" style="font-size: 14px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shoptransportation/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
            </th>
        <?php } ?>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transportation/one/index']->childs as $value) {
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

