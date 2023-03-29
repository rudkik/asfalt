<div class="row">
    <div class="col-md-12">
        <?php
        $view = View::factory('smmarket/customer/35/paginator');
        $view->siteData = $siteData;

        $urlParams = $siteData->urlParams;
        $urlParams['page'] = '-pages-';

        $shopGoodRubricID = Request_RequestParams::getParamInt('shop_table_rubric_id');
        if($shopGoodRubricID > 0){
            $urlParams['shop_table_rubric_id'] = $shopGoodRubricID;
        }

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <?php
    $n = 4;
    $i = 1;
    foreach ($data['view::shopbranch/index']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="row">';
            $i = 1;
        }
        $i++;
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

        $shopGoodRubricID = Request_RequestParams::getParamInt('shop_table_rubric_id');
        if($shopGoodRubricID > 0){
            $urlParams['shop_table_rubric_id'] = $shopGoodRubricID;
        }

        $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

        $view->urlData = $siteData->urlBasic.$siteData->url.$url;
        $view->urlAction = 'href';

        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>