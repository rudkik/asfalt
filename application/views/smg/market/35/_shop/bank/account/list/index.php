<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbankaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Номер счета</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbankaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbankaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'bank_id.name'); ?>" class="link-black">Банк</a>
        </th>
            <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/bank/account/one/index']->childs as $value) {
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

