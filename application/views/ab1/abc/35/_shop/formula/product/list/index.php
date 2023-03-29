<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopoperation/save');?>">
            </span>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'contract_date'); ?>" class="link-black">Дата приказа</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black">Дата создания</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index'). Func::getAddURLSortBy($siteData->urlParams, 'contract_number'); ?>" class="link-black">№ приказа</a>
        </th>
        <th>Продукция</th>
        <th class="width-105"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/formula/product/one/index']->childs as $value) {
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

