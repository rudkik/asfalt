<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-95 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_attorney_id.number'); ?>" class="link-black">Доверенность</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_contract_id.number'); ?>" class="link-black">Договор</a>
        </th>
        <th class="width-120">Вид продукции</th>
        <th class="width-110">Вид оплаты</th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'is_delivery'); ?>" class="link-black">Доставка</a>
        </th>
        <th class="width-105">Статус</th>
        <th class="width-130">Филиал</th>
        <?php if(!Request_RequestParams::getParamBoolean('is_send_esf')){?>
            <th class="text-right" style="width: 82px;">
                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">До ЭСФ</a>
            </th>
        <?php }?>
        <th class="width-110"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/index']->childs as $value) {
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

