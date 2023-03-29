<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Номер</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th style="width: 225px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ договора</a>
        </th>
        <th class="width-97 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th style="width: 218px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/proforma/one/index']->childs as $value) {
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

