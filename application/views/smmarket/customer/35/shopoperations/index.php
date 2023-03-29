<div class="row btn-add">
    <div class="col-md-4">
        <a href="/customer/shopoperation/new" class="btn btn-success">Добавить менеджера</a>
    </div>
    <div class="col-md-8">
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
        <table class="table table-hover table-green table-column-5">
            <thead>
            <tr>
                <th class="tr-header-id"><a href="/customer/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ID</a></th>
                <th><a href="/customer/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>">ФИО</a></th>
                <th><a href="/customer/shopoperation/email<?php echo Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>">E-mail</a></th>
                <th><a href="/customer/shopoperation/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'options.phone'); ?>">Телефон</a></th>
                <th class="tr-header-buttom-2"></th>
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