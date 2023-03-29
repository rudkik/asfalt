<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopoperation/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">ФИО</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-black">E-mail</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index'). Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.email', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/operation/one/index']->childs as $value) {
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

