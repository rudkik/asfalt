<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-95 text-right">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_attorney_id.number'); ?>" class="link-black">Доверенность</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_contract_id.number'); ?>" class="link-black">Договор</a>
        </th>
        <th class="width-120">Вид продукции</th>
        <th class="width-100">Вид оплаты</th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'is_delivery'); ?>" class="link-black">Доставка</a>
        </th>
        <th style="width: 140px">Статус</th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'date_give_to_client'); ?>" class="link-black">Выдано клиенту</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'date_received_from_client'); ?>" class="link-black">Получено от клиента</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, $siteData->url). Func::getAddURLSortBy($siteData->urlParams, 'date_give_to_bookkeeping'); ?>" class="link-black">Сдано в бухгалтерию</a>
        </th>
        <th class="width-100"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/decryption']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $_GET;
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

