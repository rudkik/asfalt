<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamInt('good_select_type_id') != 3723)
                    && (Request_RequestParams::getParamBoolean('is_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_not_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_delete') !== TRUE)){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Все</a></li>
                <li <?php if(Request_RequestParams::getParamInt('good_select_type_id') == 3723){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&good_select_type_id=3723<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Новинки</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_public')){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&is_public=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Опуб.</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_not_public')){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&is_not_public=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Неопуб.</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_delete')){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&is_delete=1&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Удаленные</a></li>
                <li><a href="/sadmin/shopgood/index_edit?type=3722&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Редактирование</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <a href="/sadmin/shopgood/new?type=3722<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-warning">
                <i class="fa fa-fw fa-plus"></i>
                Добавить товар
            </a>
        </div>
        <?php
        $view = View::factory('smmarket/sadmin/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        $urlParams['shop_branch_id'] = Request_RequestParams::getParamInt('shop_branch_id');

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
                <th class="tr-header-number"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>">Запуск</a></th>
                <th class="tr-header-number"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'good_select_type_id'); ?>">Новинки</a></th>
                <th class="tr-header-id"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th colspan="2" style="min-width: 200px"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>">Товар</a></th>
                <th class="tr-header-amount"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>">Цена</a></th>
                <?php if($siteData->branchID == 0){ ?>
                    <th class="tr-header-rubric"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_id'); ?>">Поставщик</a></th>
                <?php } ?>
                <th class="tr-header-rubric"><a href="/sadmin/shopgood/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_table_rubric_id'); ?>">Категория</a></th>
                <th class="tr-header-buttom-vertical"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopgood/index']->childs as $value) {
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
        $view = View::factory('smmarket/sadmin/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        $urlParams['shop_branch_id'] = Request_RequestParams::getParamInt('shop_branch_id');

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>