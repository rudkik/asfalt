<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th style="width: 124px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="tr-header-buttom">
            <a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ расходника</a>
        </th>
        <th>Период</th>
        <th style="width: 110px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/consumable/one/index']->childs as $value) {
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

