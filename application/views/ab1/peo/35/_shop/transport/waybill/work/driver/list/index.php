<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.number'); ?>" class="link-black">Путевой лист</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.shop_transport_id.name'); ?>" class="link-black">Транспортное средство</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_waybill_id.shop_transport_id.number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_work_id.name'); ?>" class="link-black">Вид выработки</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillworkdriver/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
    </tr>
    <tbody id="cars">
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/list/total']; ?>
    <?php
    foreach ($data['view::_shop/transport/waybill/work/driver/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    <?php echo $siteData->globalDatas['view::_shop/transport/waybill/work/driver/list/total']; ?>
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