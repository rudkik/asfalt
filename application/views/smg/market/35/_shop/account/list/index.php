<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'login'); ?>" class="link-black">Логин</a>
        </th>
        <th class="width">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Комментраий </a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopaccount/index'). Func::getAddURLSortBy($siteData->urlParams, 'link'); ?>" class="link-black">Ссылка</a>
        </th>
        <th class="width-70">Файл</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/account/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
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

