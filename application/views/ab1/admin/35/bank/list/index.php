<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/bank/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название банка</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/bank/index'). Func::getAddURLSortBy($siteData->urlParams, 'address'); ?>" class="link-black">Адрес банка</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/bank/index'). Func::getAddURLSortBy($siteData->urlParams, 'bik'); ?>" class="link-black">БИК</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/bank/index'). Func::getAddURLSortBy($siteData->urlParams, 'bin'); ?>" class="link-black">БИН/ИИН</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::bank/one/index']->childs as $value) {
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

