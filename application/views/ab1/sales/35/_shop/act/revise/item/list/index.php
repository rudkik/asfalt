<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th class="width-97">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">Номер</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th style="width: 50%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th style="width: 50%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_cache'); ?>" class="link-black">Вид оплаты</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/act/revise/item/one/index']->childs as $value) {
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

