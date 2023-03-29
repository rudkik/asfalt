<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/misstype/index'). Func::getAddURLSortBy($siteData->urlParams, 'miss_from'); ?>" class="link-black">Период от</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/misstype/index'). Func::getAddURLSortBy($siteData->urlParams, 'miss_to'); ?>" class="link-black">Период до</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/misstype/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Работник</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/misstype/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Вид прогула</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::miss-type/one/index']->childs as $value) {
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

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

