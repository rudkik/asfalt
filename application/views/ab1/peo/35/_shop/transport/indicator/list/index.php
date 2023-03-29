<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportindicator/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_expense_fuel'); ?>" class="link-black">ГСМ</a>
        </th>
        <th class="tr-header-public">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportindicator/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_calc_wage'); ?>" class="link-black">З/П</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportindicator/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportindicator/index'). Func::getAddURLSortBy($siteData->urlParams, 'identifier'); ?>" class="link-black">Идентификатор</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/indicator/one/index']->childs as $value) {
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
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>