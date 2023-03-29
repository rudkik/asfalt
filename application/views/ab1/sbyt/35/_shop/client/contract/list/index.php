<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th style="width: 27px ">
            <i class="fa fa-fw fa-plus"></i>
        </th>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="#">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-165">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ договора</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Дата начала</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Дата окончания</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'block_amount'); ?>" class="link-black">Израсходовано</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'balance_amount'); ?>" class="link-black">Остаток</a>
        </th>
        <th class="width-70">Файл</th>
        <th class="width-150">
            Кто создал
            <br> Кто изменил
        </th>
        <th style="width: 115px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/client/contract/one/index']->childs as $value) {
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

