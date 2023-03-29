<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/customer/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        $urlParams['id'] = Request_RequestParams::getParamInt('id');

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <?php
    foreach ($data['view::shopgood/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/customer/35/paginator');
        $view->siteData = $siteData;
        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';
        $urlParams['id'] = Request_RequestParams::getParamInt('id');

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>