<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-100">Номер ТТН</th>
        <th class="tr-header-short-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
         </th>
        <th class="tr-header-short-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'weighted_exit_at'); ?>" class="link-black">Дата выезда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th style="width: 79px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_attorney_id.number'); ?>" class="link-black">Доверенность</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-60">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="tr-header-amount-currency">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_delivery_id.name'); ?>" class="link-black">Доставка</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'shop_turn_place_id.name'); ?>" class="link-black">Место погрузки</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/history'). Func::getAddURLSortBy($siteData->urlParams, 'cash_operation_id.name'); ?>" class="link-black">Оператор</a>
        </th>
        <th style="width: 196px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/history']->childs as $value) {
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

