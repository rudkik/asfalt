<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if((Request_RequestParams::getParamStr('shop_bill_status_id') != '1,3,4,5,8')
                    && (Request_RequestParams::getParamStr('shop_bill_status_id') != '2,4,6,7,9')){ echo 'class="active"';}?>><a href="/supplier/shopbill/index<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Все</a></li>
                <li <?php if(Request_RequestParams::getParamStr('shop_bill_status_id') == '1,3,4,5,8'){ echo 'class="active"';}?>><a href="/supplier/shopbill/index?shop_bill_status_id=1,3,4,5,8<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Текущие</a></li>
                <li <?php if(Request_RequestParams::getParamStr('shop_bill_status_id') == '2,4,6,7,9'){ echo 'class="active"';}?>><a href="/supplier/shopbill/index?shop_bill_status_id=2,4,6,7,9<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Старые</a></li>
                <li><a href="/supplier/shopbill/statistic<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Статистика продаж</a></li>
            </ul>
        </div>
        <div class="btn-add-data">
            <a href="/supplier/shopbill/report_abc_rating<?php echo URL::query(array('limit_page' => 0, 'shop_branch_id' => $siteData->branchID)); ?>" class="btn btn-primary">
                Отчет ABC
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
        <table class="table table-hover table-green table-column-7">
            <thead>
            <tr>
                <th class="tr-header-id"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">№ заказа</a></th>
                <th class="tr-header-date"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>">Дата создания</a></th>
                <th class="tr-header-date"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'client_delivery_date'); ?>">Дата поставки</a></th>
                <th class="tr-header-status"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_status_id'); ?>">Статус</a></th>
                <th style="min-width: 200px"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_root_id'); ?>">Торговая точка</a></th>
                <th style="min-width: 200px"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_id'); ?>">Портфель</a></th>
                <th class="tr-header-amount"><a href="/supplier/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>">Сумма</a></th>
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