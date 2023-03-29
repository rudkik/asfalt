<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_upload'); ?>" class="link-black">Загрузка</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_drain_chute_id.name'); ?>" class="link-black">Лоток слива НБЦ</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_storage_id.name'); ?>" class="link-black">Сырьевой парк</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_storage_id.name'); ?>" class="link-black">Куб готовой продукции</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/raw/storage/drain/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
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
</div>

