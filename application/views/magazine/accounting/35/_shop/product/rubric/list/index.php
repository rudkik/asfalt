<table class="table table-hover table-db table-tr-line">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Рубрика</a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/index'). Func::getAddURLSortBy($siteData->urlParams, 'root_id'); ?>" class="link-black">Родитель</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/product/rubric/one/index']->childs as $value) {
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

