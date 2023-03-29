<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamBoolean('is_delete') !== TRUE)){ echo 'class="active"';}?>><a href="/sadmin/shopoperation/index?&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Все</a></li>
                <li <?php if(Request_RequestParams::getParamBoolean('is_delete')){ echo 'class="active"';}?>><a href="/sadmin/shopoperation/index?&is_delete=1&is_public_ignore=1<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>">Удаленные</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <a href="/sadmin/shopoperation/new?type=3722<?php if($siteData->branchID > 0) {echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i>
                Добавить менеджера
            </a>
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
        <table class="table table-hover table-green">
            <thead>
            <tr>
                <th class="tr-header-id"><a href="/sadmin/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th colspan="2" style="min-width: 200px"><a href="/sadmin/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ФИО</a></th>
                <th  style="min-width: 200px"><a href="/sadmin/shopoperation/email<?php echo Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>">E-mail</a></th>
                <th  style="min-width: 200px"><a href="/sadmin/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'options.phone'); ?>">Телефон</a></th>
                <th class="tr-header-buttom-vertical"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopoperation/index']->childs as $value) {
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

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>