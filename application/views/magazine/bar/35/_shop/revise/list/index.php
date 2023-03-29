<table class="table table-hover table-db table-tr-line">
    <tr>
        <th style="width: 90px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">Номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="text-right" style="width: 149px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_actual'); ?>" class="link-black">Фактичное кол-во</a>
        </th>
        <th class="text-right" style="width: 132px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Текущее кол-во</a>
        </th>
        <th class="tr-header-amount text-right">
            Разница
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/revise/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/bar/35/paginator');
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

