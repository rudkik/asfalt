<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="width-75" style="font-size: 11px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_check'); ?>" class="link-black">Контроль</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_load_file'); ?>" class="link-black">/Автомат.</a>
        </th>
        <th class="width-60 text-center" style="font-size: 11px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_store'); ?>" class="link-black">Склад</a>
        </th>
        <th class="width-95" style="font-size: 12px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата докум.</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ докум.</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shoppaymentcourier/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="width-85 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-65 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th style="width: 260px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'esf_number'); ?>" class="link-black">№ ЭСФ</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index'). Func::getAddURLSortBy($siteData->urlParams, 'esf_date'); ?>" class="link-black">Дата ЭСФ</a>
        </th>
        <th class="width-130"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/receive/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<?php
$view = View::factory('smg/_all/35/paginator');
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
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>

