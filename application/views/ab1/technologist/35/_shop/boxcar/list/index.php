<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="text-right width-40">№</th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_arrival'); ?>" class="link-black">Дата подачи</a>
        </th>
        <th class="width-110">Статус</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ вагона</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Тоннаж</a>
        </th>
    </tr>
    <?php
    $i = ($siteData->page - 1) * $siteData->limitPage + 1;
    foreach ($data['view::_shop/boxcar/one/index']->childs as $value) {
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

