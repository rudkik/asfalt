<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_subdivision_id.name'); ?>" class="link-black">Подразделение</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_heap_id.name'); ?>" class="link-black">Место хранения</a>
        </th>
        <th>Рецепт</th>
        <th class="text-right width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'level'); ?>" class="link-black">Уровень</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopregistermaterial/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/register/material/one/tree']->childs as $value) {
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

