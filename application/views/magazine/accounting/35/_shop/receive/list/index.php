<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="width-45">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_esf'); ?>" class="link-black">ЭСФ</a>
        </th>
        <th class="width-45">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_nds'); ?>" class="link-black">НДС</a>
        </th>
        <th style="width: 116px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Номер</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'esf_type_id'); ?>" class="link-black">Вид ЭСФ</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата документа</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th style="width: 240px"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/receive/one/index']->childs as $value) {
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
<style>
    .icheckbox_minimal-blue.checked.disabled {
        background-position: -40px 0 !important;
    }
</style>