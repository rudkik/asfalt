<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left margin-bottom-5px">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamBoolean('is_active') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_not_active') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_not_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_delete') !== TRUE)){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_public_ignore=1">Все</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_active')){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_active=1&is_public_ignore=1">Активированные</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_not_active')){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_not_active=1&is_public_ignore=1">Неактивированные</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_public')){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_public=1">Опубликованные</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_not_public')){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_not_public=1">Неопубликованные</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_delete')){ echo 'class="active"';}?>><a href="/sadmin/shopbranch/index?type=3731&is_delete=1&is_public_ignore=1">Удаленные</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <a href="/sadmin/shopbranch/new?type=3731" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i>
                Добавить торговую точку
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="btn-group" style="margin-top: 5px;">
            <a target="_blank" href="/sadmin/shopbranch/savefile<?php echo URL::query(array('file-type' => 'xls')); ?>" class="btn btn-success">
                Сохранить в Excel-файл
            </a>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a target="_blank" href="/sadmin/shopbranch/savefile<?php echo URL::query(array('file-type' => 'xls', 'file-name' => 'plane-table')); ?>" >Отчет по планшетам</a></li>
            </ul>
        </div>

        <?php
        $view = View::factory('smmarket/sadmin/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-green column-center-1 column-center-2">
            <thead>
            <tr>
                <th class="tr-header-number">№</th>
                <th class="tr-header-number" style="font-size: 10px;"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_active'); ?>">Активирован?</a></th>
                <th class="tr-header-number" style="font-size: 10px;"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>">Опубликован?</a></th>
                <th class="tr-header-id"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th colspan="2" style="min-width: 200px"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>">Торговая точка</a></th>
                <th class="tr-header-id"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_catalog_id'); ?>">Категория</a></th>
                <th style="min-width: 200px"><a href="/sadmin/shopbranch/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'options.manager_name'); ?>">Менеджер</a></th>
                <th class="tr-header-buttom-vertical"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = ($siteData->page - 1) * $siteData->limitPage + 1;
            foreach ($data['view::shopbranch/index']->childs as $value){
                echo str_replace('#index#', $i, $value->str);
                $i++;
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

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>