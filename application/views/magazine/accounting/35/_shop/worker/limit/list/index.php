<table class="table table-hover table-db table-tr-line">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerlimit/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Сотрудник</a>
        </th>
        <th class="width-115 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerlimit/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-105 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerlimit/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Лимит</a>
        </th>
        <th class="width-115 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerlimit/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount_block'); ?>" class="link-black">Израсходавано</a>
        </th>
        <th class="width-105 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerlimit/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount_balance'); ?>" class="link-black">Остаток</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/worker/limit/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/accounting/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $siteData->urlParams;
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

