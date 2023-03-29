<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th style="width: 92px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/entry'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th class="width-60">Тара</th>
        <th style="width: 110px"></th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/entry'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/entry'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукция</a>
        </th>
        <th class="width-100">Номер ТТН</th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/exit']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12">
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


