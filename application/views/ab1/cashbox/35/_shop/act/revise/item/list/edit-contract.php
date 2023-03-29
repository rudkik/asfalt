<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-97">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">Номер</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th style="width: 50%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th style="width: 50%">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'is_cache'); ?>" class="link-black">Вид оплаты</a>
        </th>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'is_cis_receiveache'); ?>" class="link-black">Вид операции</a>
        </th>
        <th style="width: 210px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/edit_contract'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_contract_id.number'); ?>" class="link-black">Договор</a>
        </th>
        <th class="width-195">
            Файл
        </th>
    </tr>
    <?php
    foreach ($data['view::_shop/act/revise/item/one/edit-contract']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
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

