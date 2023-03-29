<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_delivery_department_id'); ?>" class="link-black">Цех доставки</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'delivery_amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-130">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_attorney_id.number'); ?>" class="link-black">Доверенность</a>
        </th>
        <th class="width-105">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_contract_id.number'); ?>" class="link-black">Договор</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'act_service_paid_type_id.name'); ?>" class="link-black">Вид оплаты</a>
        </th>
        <th class="width-105">Статус</th>
        <th class="width-130">Филиал</th>
        <?php if(!Request_RequestParams::getParamBoolean('is_send_esf')){?>
            <th class="text-right width-90">
                <a href="<?php echo Func::getFullURL($siteData, '/shopactservice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">До ЭСФ</a>
            </th>
        <?php }?>
        <?php if((!Request_RequestParams::getParamBoolean('is_send_esf')) || $siteData->operation->getIsAdmin()){ ?>
            <th style="width: 127px"></th>
        <?php } ?>
    </tr>
    <?php
    foreach ($data['view::_shop/act/service/one/index']->childs as $value) {
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

