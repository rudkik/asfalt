<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'city_name'); ?>" class="link-black">Город</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'street'); ?>" class="link-black">Улица</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'house'); ?>" class="link-black">Дом</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'apartment'); ?>" class="link-black">Квартира</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'latitude'); ?>" class="link-black">Широта</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbilldeliveryaddress/index'). Func::getAddURLSortBy($siteData->urlParams, 'longitude'); ?>" class="link-black">Долгота</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/bill/delivery/address/one/index']->childs as $value) {
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

