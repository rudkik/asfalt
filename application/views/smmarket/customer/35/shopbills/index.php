<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/customer/35/paginator');
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
                <th class="tr-header-id"><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">№ заказа</a></th>
                <th class="tr-header-date"><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'client_delivery_date'); ?>">Дата поставки</a></th>
                <th class="tr-header-status"><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_status_id'); ?>">Статус</a></th>
                <th><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_id'); ?>">Поставщик</a></th>
                <th class="tr-header-manager"><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'updated_user_id'); ?>">Менеджер</a></th>
                <th class="tr-header-amount"><a href="/customer/shopbill/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>">Сумма</a></th>
                <th class="tr-header-buttom"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::shopbill/index']->childs as $value) {
                echo $value->str;
            }
            ?>
            <body>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/customer/35/paginator');
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