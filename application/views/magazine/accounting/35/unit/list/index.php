<table class="table table-hover table-db table-tr-line">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/unit/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID 1C</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/unit/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/unit/index'). Func::getAddURLSortBy($siteData->urlParams, 'name_1c'); ?>" class="link-black">Название в 1С</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::unit/one/index']->childs as $value) {
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

