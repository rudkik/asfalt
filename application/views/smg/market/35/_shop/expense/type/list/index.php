<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php Func::getFullURL($siteData, '/shopexpensetype/save');?>">
            </span>
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpensetype/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_expanse'); ?>" class="link-black">Расход?</a>
        </th>
        <th class="width-50 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpense/index'). Func::getAddURLSortBy($siteData->urlParams, 'kpn'); ?>" class="link-black">КПН</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopexpensetype/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/expense/type/one/index']->childs as $value) {
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

