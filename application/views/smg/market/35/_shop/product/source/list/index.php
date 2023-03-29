<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-80">
            Фото
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.article'); ?>" class="link-black">Артикул</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.shop_brand_id.name'); ?>" class="link-black">Бренд</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_rubric_source_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_rubric_source_id.commission'); ?>" class="link-black">Процент рубрики</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.price'); ?>" class="link-black">Цена продажи</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Себестоимость</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Реком. цена</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'profit'); ?>" class="link-black">Прибыль</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'url'); ?>" class="link-black">Ссылка размещения</a>
        </th>
        <th class="text-right width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_source'); ?>" class="link-black">Цена товара</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_min'); ?>" class="link-black">Мин. цена</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'price_max'); ?>" class="link-black">Мак. цена</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'root_shop_product_id.article'); ?>" class="link-black">Связь</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/product/source/one/index']->childs as $value) {
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

