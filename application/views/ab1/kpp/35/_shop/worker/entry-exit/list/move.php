<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_entry'); ?>" class="link-black">Время входа</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_exit'); ?>" class="link-black">Время выхода</a>
        </th>
        <th class="text-left">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'). Func::getAddURLSortBy($siteData->urlParams, 'guest_id.name'); ?>" class="link-black">Работник/Гость</a>
        </th>
        <th class="text-left">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_department_id.name'); ?>" class="link-black">Отдел</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_passage_id.name'); ?>" class="link-black">Место входа</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'exit_shop_worker_passage_id.name'); ?>" class="link-black">Место выхода</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_car'); ?>" class="link-black">На машине</a>
        </th>
    </tr>
    <tbody id="list" data-date="<?php echo date('d.m.Y H:i:s'); ?>">
    <?php
    foreach ($data['view::_shop/worker/entry-exit/one/move']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
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
<style>
    .blink {
        -webkit-animation: blink 1s linear infinite;
        animation: blink 1s linear infinite;
    }
    @-webkit-keyframes blink {
        100% { color: rgba(34, 34, 34, 0); }
    }
    @keyframes blink {
        100% { color: rgba(34, 34, 34, 0); }
    }
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>