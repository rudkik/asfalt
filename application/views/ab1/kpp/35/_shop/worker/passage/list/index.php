<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/save');?>">
            </span>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">Серийный номер</a>
        </th>
        <th style="width: 165px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'controller_number'); ?>" class="link-black">Ключ аутентификации</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'ip'); ?>" class="link-black">IP</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'last_operation'); ?>" class="link-black">Последняя команда</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_connect'); ?>" class="link-black">Дата команды</a>
        </th>
        <th class="width-90 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_car'); ?>" class="link-black">На машине</a>
        </th>
        <th class="width-60 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_exit'); ?>" class="link-black">Выход</a>
        </th>
        <th class="width-110 text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerpassage/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_inside_move'); ?>" class="link-black">Перемещение</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/worker/passage/one/index']->childs as $value) {
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

