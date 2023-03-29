<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
        </th>
        <th class="tr-header-id">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-photo">Фото</th>
        <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))
            || (Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))){ ?>
            <th class="tr-header-rubric">Рубрика</th>
        <?php } ?>
        <th>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-sort">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'order'); ?>" class="link-black">Сортировка</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'order'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.order', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::shopnew/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('cabinet/35/paginator');
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
