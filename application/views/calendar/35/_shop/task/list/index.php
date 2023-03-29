<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_from'); ?>" class="link-black">Date start</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_to'); ?>" class="link-black">Date end</a>
        </th>
        <th style="min-width: 90px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Product</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_product_id.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th style="min-width: 90px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_rubric_id.name'); ?>" class="link-black">Category</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_rubric_id.name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_rubric_id.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th style="min-width: 90px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_partner_id.name'); ?>" class="link-black">Partner</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_partner_id.name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_partner_id.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Project</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Description</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.text', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="width-80 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'cost'); ?>" class="link-black">Cost</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'cost'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.cost', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th style="min-width: 80px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_result_id.name'); ?>" class="link-black">Result</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_result_id.name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_result_id.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="width-80 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptask/index'). Func::getAddURLSortBy($siteData->urlParams, 'mbc'); ?>" class="link-black">MBC</a>
        </th>
        <th class="tr-header-line-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/task/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('calendar/35/paginator');
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

