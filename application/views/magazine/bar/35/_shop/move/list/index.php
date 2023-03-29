<table class="table table-hover table-db table-tr-line">
    <tr>
        <th style="width: 116px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmove/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmove/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">Номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmove/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_id'); ?>" class="link-black">Откуда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmove/index'). Func::getAddURLSortBy($siteData->urlParams, 'branch_move_id'); ?>" class="link-black">Куда</a>
        </th>
        <th class="tr-header-amount text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmove/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/move/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/bar/35/paginator');
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

