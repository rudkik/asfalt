<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left margin-bottom-5px">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php
                $partner = Request_RequestParams::getParamInt('partner');
                if(!(($partner > 0) && ($partner < 4))){ echo 'class="active"';}?>><a href="/supplier/shopbranch/index?type=3731">Все</a></li>
                <li <?php if(Request_RequestParams::getParamInt('partner') == 1){ echo 'class="active"';}?>><a href="/supplier/shopbranch/index?type=3731&partner=1">Мои партнеры</a></li>
                <li <?php if(Request_RequestParams::getParamInt('partner') == 2){ echo 'class="active"';}?>><a href="/supplier/shopbranch/index?type=3731&partner=2">Ожидают подтверждения</a></li>
                <li <?php if(Request_RequestParams::getParamInt('partner') == 3){ echo 'class="active"';}?>><a href="/supplier/shopbranch/index?type=3731&partner=3">Не является моим партнером</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-green column-center-1 column-center-2">
            <thead>
            <tr>
                <th class="tr-header-id"><a href="/supplier/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th colspan="2" style="min-width: 200px"><a href="/supplier/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>">Торговая точка</a></th>
                <th class="tr-header-id"><a href="/supplier/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_catalog_id'); ?>">Категория</a></th>
                <th class="tr-header-buttom-vertical-partners"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopbranch/index']->childs as $value){
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