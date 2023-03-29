<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2">Подразделение</th>
        <th colspan="6" class="text-right">Количество в условных единицах</th>
    </tr>
    <tr>
        <th class="width-120 text-right">Сегодня</th>
        <th class="width-120 text-right">Вчера</th>
        <th class="width-120 text-right">Неделя</th>
        <th class="width-120 text-right">Месяц</th>
        <th class="width-120 text-right">Прошлый месяц</th>
        <th class="width-120 text-right">Год</th>
    </tr>
    <?php
    foreach ($data['view::_shop/move/car/one/statistics']->childs as $value) {
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

