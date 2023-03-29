<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'fuel_id.name'); ?>" class="link-black">Название ГСМ</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_move_client_id.name'); ?>" class="link-black">Подразделение</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_mark_id.name'); ?>" class="link-black">Марка + гос.номер</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во ГСМ</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/fuel/expense/one/index']->childs as $value) {
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

