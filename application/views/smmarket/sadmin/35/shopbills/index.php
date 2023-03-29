<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamStr('shop_bill_status_id') != '1,3,4,5,8')
                    && (Request_RequestParams::getParamStr('shop_bill_status_id') != '2,4,6,7,9')){ echo 'class="active"';}?>><a href="/sadmin/shopbill/index">Все</a></li>
                <li <?php if(Request_RequestParams::getParamStr('shop_bill_status_id') == '1,3,4,5,8'){ echo 'class="active"';}?>><a href="/sadmin/shopbill/index?shop_bill_status_id=1,3,4,5,8">Текущие</a></li>
                <li <?php if(Request_RequestParams::getParamStr('shop_bill_status_id') == '2,4,6,7,9'){ echo 'class="active"';}?>><a href="/sadmin/shopbill/index?shop_bill_status_id=2,4,6,7,9">Старые</a></li>
                <li><a href="/sadmin/shopbill/static">Статистика продаж</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <div class="btn-group" style="margin-top: 5px;">
                <a target="_blank" href="/sadmin/shopbill/savefile<?php echo URL::query(array('file-type' => 'xls')); ?>" class="btn btn-success">
                    Сохранить в Excel-файл
                </a>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a target="_blank" href="/sadmin/shopbill/report_branch_bill_amount" >Отчет по поставщикам</a></li>
                    <li><a target="_blank" href="/sadmin/shopbill/report_root_bill_amount" >Отчет по торговым точкам</a></li>
                    <li><a target="_blank" href="/sadmin/shopbill/report_root_last_bill" >Отчет последний заказ у торговой точки</a></li>
                </ul>
            </div>
            <a target="_blank" href="/sadmin/shopbill/report_abc_rating<?php echo URL::query(array('limit_page' => 0, 'shop_branch_id' => $siteData->branchID)); ?>" class="btn btn-primary" style="margin-top: 13px;">
                Отчет ABC
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
        <table class="table table-hover table-green table-column-7">
            <thead>
            <tr>
                <th class="tr-header-id"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">№ заказа</a></th>
                <th class="tr-header-date"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>">Дата создания</a></th>
                <th class="tr-header-date"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'client_delivery_date'); ?>">Дата поставки</a></th>
                <th class="tr-header-status"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'bill_status_id'); ?>">Статус</a></th>
                <th style="min-width: 200px"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_id'); ?>">Поставщик</a></th>
                <th style="min-width: 200px"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_id'); ?>">Торговая точка</a></th>
                <th class="tr-header-amount"><a href="/sadmin/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>">Сумма</a></th>
                <th style="width: 52px;">МПР</th>
                <th class="tr-header-buttom"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopbill/index']->childs as $value) {
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