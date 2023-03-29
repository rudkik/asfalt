<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-date" style="width: 155px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <?php if($siteData->operation->getIsAdmin()){ ?>
        <th class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/index'). Func::getAddURLSortBy($siteData->urlParams, 'asu_operation_id.name'); ?>" class="link-black">Оператор</a>
        </th>
        <?php } ?>
    </tr>
    <?php
    foreach ($data['view::_shop/move/car/one/index']->childs as $value) {
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

