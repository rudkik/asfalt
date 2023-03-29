<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoptransport/save');?>">
            </span>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Код 1С</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Марка + Гос. номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_view_id.name'); ?>" class="link-black">Вид транспорта</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_view_id.name'); ?>" class="link-black">Тип транспорта 1С</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_work_id.name'); ?>" class="link-black">Вид работ</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_wage_id.name'); ?>" class="link-black">Правила расчета выработки</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'transport_form_payment_id.name'); ?>" class="link-black">Форма оплаты</a>
        </th>
        <th class="width-90 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'milage'); ?>" class="link-black">Пробег</a>
        </th>
        <th class="width-120 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportmark/index'). Func::getAddURLSortBy($siteData->urlParams, 'fuel_quantity'); ?>" class="link-black">Кол-во топлива</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/mark/one/index']->childs as $value) {
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

