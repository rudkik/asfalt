<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-60 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'is_store'); ?>" class="link-black">Склад</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_receive_id.date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_receive_id.number'); ?>" class="link-black">№ накладной</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена закупа</a>
        </th>
        <th class="text-right width-65">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_balance'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="text-right width-100">Стоимость</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/receive/item/one/stock']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
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