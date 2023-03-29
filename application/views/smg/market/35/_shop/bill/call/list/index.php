<table class="table table-striped table-bordered table-hover">
    <tr>
        <th rowspan="2" class="tr-header-public">
                <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_call'); ?>" class="link-black">Звонок совершон</a>
        </th>
        <th  rowspan="2" class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_id.name'); ?>" class="link-black">Заказ</a>
        </th>
        <th rowspan="2" class="width-135">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'phone'); ?>" class="link-black">Телефон</a>
        </th>
        <th  rowspan="2" class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_call_status_id.name'); ?>" class="link-black">Статус звонка</a>
        </th>
       <th colspan="2" class="text-center">
           Время
       </th>
        <th rowspan="2" class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_operation_id.name'); ?>" class="link-black">Оператор</a>
        </th>
        <th rowspan="2" class="">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Комментарий после звонка</a>
        </th>
            <th rowspan="2" class="tr-header-buttom"></th>
    </tr>
    <tr>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'call_at'); ?>" class="link-black">Звонка</a>
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillcall/index'). Func::getAddURLSortBy($siteData->urlParams, 'plan_call_at'); ?>" class="link-black">По плану</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/bill/call/one/index']->childs as $value) {
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

