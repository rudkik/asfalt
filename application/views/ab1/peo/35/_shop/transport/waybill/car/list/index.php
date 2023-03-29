<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-40">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_wage'); ?>" class="link-black">ЗП?</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Транспортное средство</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            Пункт отправления
        </th>
        <th>
            Пункт назначения
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'product_name'); ?>" class="link-black">Наименование груза</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_route_id.name'); ?>" class="link-black">Маршрут</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'coefficient'); ?>" class="link-black">Коэффициент</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'count_trip'); ?>" class="link-black">Кол-во рейсов</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'distance'); ?>" class="link-black">Расстояние, км</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Масса</a>
        </th>
        <th class="width-130 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'wage'); ?>" class="link-black">Стоимость рейса</a>
        </th>
    </tr>
    <tbody id="cars">
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/car/list/total']; ?>
    <?php
    foreach ($data['view::_shop/transport/waybill/car/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/car/list/total']; ?>
    </tbody>
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