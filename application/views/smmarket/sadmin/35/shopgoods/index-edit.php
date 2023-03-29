<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamInt('good_select_type_id') != 3723)
                    && (Request_RequestParams::getParamBoolean('is_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_not_public') !== TRUE)
                    && (Request_RequestParams::getParamBoolean('is_delete') !== TRUE)){ echo 'class="active"';}?>><a href="/sadmin/shopgood/index?type=3722&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Все</a></li>
                <li><a href="/sadmin/shopgood/index?type=3722&good_select_type_id=3723<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Новинки</a></li>
                <li><a href="/sadmin/shopgood/index?type=3722&is_public=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Опубликованные</a></li>
                <li><a href="/sadmin/shopgood/index?type=3722&is_not_public=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Неопубликованные</a></li>
                <li><a href="/sadmin/shopgood/index?type=3722&is_delete=1&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Удаленные</a></li>
                <li class="active"><a href="/sadmin/shopgood/index_edit?type=3722&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Редактирование</a></li>
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
        <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/savelist" method="post">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <table class="table table-hover table-green">
                <thead>
                <tr>
                    <th class="tr-header-number"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>">Запуск</a></th>
                    <th class="tr-header-number"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'good_select_type_id'); ?>">Новинки</a></th>
                    <th class="tr-header-id"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                    <th style="width: 200px">Сопоставление</th>
                    <th colspan="2" style="min-width: 200px"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>">Товар</a></th>
                    <th style="width: 240px"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>">Цена</a></th>
                    <?php if($siteData->branchID == 0){ ?>
                        <th class="tr-header-rubric"><a href="/sadmin/shopgood/index_edit<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_id'); ?>">Поставщик</a></th>
                    <?php } ?>
                    <th class="tr-header-buttom-vertical"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data['view::shopgood/index-edit']->childs as $value) {
                    echo $value->str;
                }
                ?>
                </tbody>
            </table>
            <div class="modal-footer">
                <div hidden>
                    <?php echo Func::getURLParamsToInput($_GET);?>

                    <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
                    <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                    <?php if($siteData->branchID > 0){ ?>
                        <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
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

<style>
    .input-group-btn button.btn-info.btn-flat{
        padding: 6px;
    }
    .price-block .input-group-addon{
        padding: 6px;
        min-width: 34px;
    }
    .price-block .col-md-6{
        padding-right: 5px;
        padding-left: 5px;
    }
    .price-block.row{
        margin-right: -5px;
        margin-left: -5px;
    }
    .price-block .form-group{
        margin-bottom: 5px;
    }
    .price-block .col-md-6:nth-child(5) .form-group, .price-block .col-md-6:nth-child(6) .form-group{
        margin-bottom: 0px;
    }
</style>