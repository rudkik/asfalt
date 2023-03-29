<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id'); ?>" class="link-black">Источник</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'root_id.name'); ?>" class="link-black">Родитель</a>
        </th>
        <th class="text-right width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'markup'); ?>" class="link-black">Наценка</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'commission'); ?>" class="link-black">Комиссия (%)</a>
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_sale'); ?>" class="link-black">Акция?</a>
        </th>
        <th class="text-right width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index'). Func::getAddURLSortBy($siteData->urlParams, 'commission_sale'); ?>" class="link-black">Комиссия при акции (%)</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/rubric/source/one/index']->childs as $value) {
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

