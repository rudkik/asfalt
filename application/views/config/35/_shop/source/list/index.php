<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'code'); ?>" class="link-black">Код</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/source/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php
$view = View::factory('config/_all/35/paginator');
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

