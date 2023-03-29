<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'esf_type_id'); ?>" class="link-black">Вид ЭСФ</a>
        </th>
        <th style="width: 116px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Номер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'number_esf'); ?>" class="link-black">Номер ЭСФ</a>
        </th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата совер- шения оборота</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'esf_date'); ?>" class="link-black">Дата выписки</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_from'); ?>" class="link-black">Период от</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_to'); ?>" class="link-black">Период до</a>
        </th>
        <th class="width-80 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="tr-header-line-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/accounting/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $siteData->urlParams;
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
    .icheckbox_minimal-blue.checked.disabled {
        background-position: -40px 0 !important;
    }
</style>

