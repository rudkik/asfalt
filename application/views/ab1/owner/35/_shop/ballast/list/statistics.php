<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2">Карьер</th>
        <th colspan="2" class="text-center">День</th>
        <th colspan="2" class="text-center">Вчера</th>
        <th colspan="2" class="text-center">Неделя</th>
        <th colspan="2" class="text-center">Месяц</th>
        <th colspan="2" class="text-center">Прошлый месяц</th>
        <th colspan="2" class="text-center">Год</th>
    </tr>
    <tr>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
        <th class="text-right">Машин</th>
        <th class="text-right">Тонн</th>
    </tr>
    <?php
    foreach ($data['view::_shop/ballast/one/statistics']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
    $urlParams['page'] = '-pages-';

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

