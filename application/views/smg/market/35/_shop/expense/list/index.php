<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="width-75" style="font-size: 11px">
            Контроль<br>/Автомат.
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата документа</a>
        </th>
        <th class="width-95" style="font-size: 11px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ документа</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
        </th>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'iik'); ?>" class="link-black">ИИК отправителя</a>
        </th>
        <th class="width-50 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'kpn'); ?>" class="link-black">КПН</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Назначение платежа</a>
        </th>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bank_account_id.name'); ?>" class="link-black">ИИК получателя</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_expense_type_id.name'); ?>" class="link-black">Вид расхода</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-130"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/expense/one/index']->childs as $value) {
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
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>