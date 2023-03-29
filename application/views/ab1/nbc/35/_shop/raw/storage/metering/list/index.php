<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата замера</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_storage_id.name'); ?>" class="link-black">Сырьевой парк</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/index'). Func::getAddURLSortBy($siteData->urlParams, 'meter'); ?>" class="link-black">Кол-во (м)</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во (т)</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/raw/storage/metering/one/index']->childs as $value) {
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

