<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  disabled>
            </span>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Транспортное средство</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.number'); ?>" class="link-black">Гос. номер</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_driver_id.name'); ?>" class="link-black">Водитель</a>
        </th>
        <th class="width-100">
            Оплата
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_view_id.name'); ?>" class="link-black">Вид транспорта</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_work_id.name'); ?>" class="link-black">Вид работ</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_subdivision_id.name'); ?>" class="link-black">Подразделение</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Комментарий</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index'). Func::getAddURLSortBy($siteData->urlParams, 'create_user_id.name'); ?>" class="link-black">Кто создал /<br> Кто редактировал</a>
        </th>
        <th class="width-120"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/waybill/one/index']->childs as $value) {
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
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>

