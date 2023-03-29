<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopcard/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcard/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcard/index'). Func::getAddURLSortBy($siteData->urlParams, 'barcode'); ?>" class="link-black">Штрихкод</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcard/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Сотрудник</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/card/one/index']->childs as $value) {
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

