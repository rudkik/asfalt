<table class="table table-hover table-db table-tr-line">
    <tr>
        <th style="width: 116px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-120 text-center">Признак происхождения</th>
        <th class="width-145 text-center">№ декларации</th>
        <th class="width-125 text-center">Номер товарной позиции</th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Цена</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_invoice'); ?>" class="link-black">Списано</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitemgtd/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_balance'); ?>" class="link-black">Остаток</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/receive/item/gtd/one/index']->childs as $value) {
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