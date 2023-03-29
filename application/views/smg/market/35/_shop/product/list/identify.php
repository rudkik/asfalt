<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopproduct/save');?>">
            </span>
        </th>
        <th class="width-70">
            Фото
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-black">Артикул</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'integrations'); ?>" class="link-black">Интеграция</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'shop_brand_id.name'); ?>" class="link-black">Бренд</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'shop_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="text-right width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена продажи</a>
        </th>
        <th class="text-right width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Себестоим.</a>
        </th>
        <th class="text-right width-90" style="font-size: 12px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'price_minus_price_cost'); ?>" class="link-black">Доход</a>
        </th>
        <th class="width-95" style="font-size: 12px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'url'); ?>" class="link-black">Ссылка поставщика</a>
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/identify'). Func::getAddURLSortBy($siteData->urlParams, 'root_shop_product_id.article'); ?>" class="link-black">Связь</a>
        </th>
        <th class="width-130"></th>
    </tr>
    </thead>
    <tbody id="list">
    <?php
    /** @var SitePageData $siteData */
    $i = ($siteData->page - 1) * $siteData->limitPage + 1;
    foreach ($data['view::_shop/product/one/identify']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);    }
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

