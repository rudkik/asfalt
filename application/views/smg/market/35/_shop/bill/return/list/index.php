<table class="table table-striped table-bordered table-hover">
    <tr>
        <th rowspan="2" class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_id.name'); ?>" class="link-black">Заказ</a>
        </th>
        <th colspan="2" class="text-center">
            Возврат
        </th>
        <th rowspan="2" class="" style="width: 180px; min-width: 180px;max-width: 180px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_return_status_id.name'); ?>" class="link-black">Статус возврата заказа</a>
        </th>
        <th colspan="2" class="text-center">
            Время
        </th>
        <th rowspan="2" class="">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Причина возврата</a>
        </th>
        <th rowspan="2" class="tr-header-buttom"></th>
    </tr>
    <tr>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_return'); ?>" class="link-black">Совершон</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_refusal'); ?>" class="link-black">Отказан</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'return_at'); ?>" class="link-black">Возврата</a>
        </th>

        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillreturn/index'). Func::getAddURLSortBy($siteData->urlParams, 'plan_return_at'); ?>" class="link-black">По плану</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/bill/return/one/index']->childs as $value) {
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

