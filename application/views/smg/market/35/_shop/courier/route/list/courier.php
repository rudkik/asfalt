    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th class="width-85">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
            </th>
            <th class="width-120">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Начало</a>
                <br><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Окончание</a>
            </th>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_id.name'); ?>" class="link-black">Курьер</a>
            </th>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_address_id_from.name'); ?>" class="link-black">Первая точка</a>
                <br><a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_address_id_to.name'); ?>" class="link-black">Последняя точка</a>
            </th>
            <th class="width-65 text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_points'); ?>" class="link-black">Кол-во точек</a>
            </th>
            <th class="width-80 text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'price_point'); ?>" class="link-black">Цена</a>
            </th>
            <th class="width-90 text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'wage'); ?>" class="link-black">Зарплата</a>
            </th>
            <th class="width-110 text-right" style="font-size: 11px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'distance'); ?>" class="link-black">Расстояние (км)</a>
            </th>
            <th class="width-80 text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/courier'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Бензин</a>
            </th>
            <th class="width-100"></th>
        </tr>
    <?php
    foreach ($data['view::_shop/courier/route/one/courier']->childs as $value) {
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

