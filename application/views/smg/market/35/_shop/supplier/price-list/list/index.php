<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_count'); ?>" class="link-black">Старые записи</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/index'). Func::getAddURLSortBy($siteData->urlParams, 'new_count'); ?>" class="link-black">Новые записи</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/supplier/price-list/one/index']->childs as $value) {
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

