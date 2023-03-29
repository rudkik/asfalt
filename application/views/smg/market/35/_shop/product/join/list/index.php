<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductjoin/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductjoin/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductjoin/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_operation_id.name'); ?>" class="link-black">Оператор</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductjoin/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/product/join/one/index']->childs as $value) {
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

