<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopbrand/save');?>">
            </span>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbrand/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_disable_dumping'); ?>" class="link-black">Отключить демпинг</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbrand/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/brand/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
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

