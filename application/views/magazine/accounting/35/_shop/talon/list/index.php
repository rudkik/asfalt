<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoptalon/save');?>">
            </span>
        </th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Сотрудник</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'validity_from'); ?>" class="link-black">Срок действия от</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'validity_to'); ?>" class="link-black">Срок действия до</a>
        </th>
        <th class="text-right width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Начислено</a>
        </th>
        <th class="text-right width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_spent'); ?>" class="link-black">Отоварено</a>
        </th>
        <th class="text-right width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptalon/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_balance'); ?>" class="link-black">Остаток</a>
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/talon/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/accounting/35/paginator');
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
</div>

