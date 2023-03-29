<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_storage_type_id.name'); ?>" class="link-black">Вид</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_storage_group_id.name'); ?>" class="link-black">Группа</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'unit'); ?>" class="link-black">Единица измерения</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'ton_in_meter'); ?>" class="link-black">Кол-во тонн в одном метре</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'size_meter'); ?>" class="link-black">Размер (м)</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoprawstorage/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Остаток (т)</a>
        </th>

        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/raw/storage/one/index']->childs as $value) {
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

