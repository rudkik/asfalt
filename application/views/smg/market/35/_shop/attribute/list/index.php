<table class="table table-striped table-bordered table-hover">
    <tr>
        <th rowspan="2" class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopattribute/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th rowspan="2" class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopattribute/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Значение атрибута</a>
        </th>
        <th rowspan="2" class="">
            <a href="<?php echo Func::getFullURL($siteData, '/shopattribute/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукция</a>
        </th>
        <th colspan="2" class="text-center">
            Атрибут продукции
        </th>
    </tr>
    <tr>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopattribute/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_attribute_type_id.name'); ?>" class="link-black">Тип</a>
        </th>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopattribute/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_attribute_rubric_id.name'); ?>" class="link-black">Рубрика</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/attribute/one/index']->childs as $value) {
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

