<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamDateTime('to_to_at') === NULL)
                    && (Request_RequestParams::getParamDateTime('from_to_at') === NULL)
                    && (Request_RequestParams::getParamBoolean('is_delete') !== TRUE)){ echo 'class="active"';}?>><a href="/supplier/shopdiscount/index?&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Все</a></li>
                <li <?php if(Request_RequestParams::getParamDateTime('to_to_at') !== NULL){ echo 'class="active"';}?>><a href="/supplier/shopdiscount/index?from_to_at=<?php echo date('Y-m-d H:i:s');?><?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Текущие</a></li>
                <li <?php if(Request_RequestParams::getParamDateTime('from_to_at') !== NULL){ echo 'class="active"';}?>><a href="/supplier/shopdiscount/index?to_to_at=<?php echo date('Y-m-d H:i:s');?><?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Старые</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_delete')){ echo 'class="active"';}?>><a href="/supplier/shopdiscount/index?is_delete=1&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Удаленные</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <a href="/supplier/shopdiscount/new?type=3722<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i>
                Добавить товар
            </a>
        </div>
        <?php
        $view = View::factory('smmarket/supplier/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        if($siteData->branchID > 0){
            $urlParams['shop_branch_id'] = $siteData->branchID;
        }

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-green">
            <thead>
            <tr>
                <th class="tr-header-number"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>">Запуск</a></th>
                <th class="tr-header-id"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th colspan="2" style="min-width: 200px"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_good_id.name'); ?>">Товар</a></th>
                <th class="tr-header-date"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>">Дата запуска</a></th>
                <th class="tr-header-date"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>">Дата окончания</a></th>
                <th class="tr-header-number"><a href="/supplier/shopdiscount/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'discount'); ?>">Скидка</a></th>
                <th class="tr-header-buttom-vertical"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopdiscount/index']->childs as $value) {
                echo $value->str;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/supplier/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        if($siteData->branchID > 0){
            $urlParams['shop_branch_id'] = $siteData->branchID;
        }

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('cabinet/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $siteData->urlParams;
    $urlParams['page'] = '-pages-';

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    if($siteData->superUserID > 0){
        $urlParams['shop_id'] = $siteData->shopID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>