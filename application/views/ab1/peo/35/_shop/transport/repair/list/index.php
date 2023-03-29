<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Транспортное средство</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'create_user_id.name'); ?>" class="link-black">Кто создал</a>
        </th>
        <th class="width-130 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/index'). Func::getAddURLSortBy($siteData->urlParams, 'hours'); ?>" class="link-black">Кол-во часов</a>
        </th>
    </tr>
    <tbody id="cars">
    <?php echo $siteData->globalDatas['view::_shop/transport/repair/list/total']; ?>
    <?php
    foreach ($data['view::_shop/transport/repair/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    <?php echo $siteData->globalDatas['view::_shop/transport/repair/list/total']; ?>
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