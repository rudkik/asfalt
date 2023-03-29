<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th style="width: 27px ">
            <i class="fa fa-fw fa-plus"></i>
        </th>
        <th class="tr-header-public">
            <span>
                <input type="checkbox" class="minimal" checked  disabled>
            </span>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ осн. дог.</a>
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ доп.</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'created_at'); ?>" class="link-black" style="font-size: 12px;">Дата регистрации</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th class="text-right width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-90" style="font-size: 12px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Дата закл.</a>
        </th>
        <th class="width-115" style="font-size: 11px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Дата оконч.</a>
        </th>
        <th class="width-145">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'client_contract_type_id.name'); ?>" class="link-black">Категория договора</a>
        </th>
        <th class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'subject'); ?>" class="link-black">Предмет договора</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'client_contract_status_id.name'); ?>" class="link-black">Статус договора</a>
        </th>
        <th class="width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index'). Func::getAddURLSortBy($siteData->urlParams, 'executor_shop_worker_id.name'); ?>" class="link-black">Исполнитель</a>
        </th>
        <th class="width-70">Файл</th>
        <th style="width: 115px;"></th>
    </tr>
    <form id="form-filter_" action="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array());?>">
        <td colspan="2" style="min-width: 80px;">
            <select name="is_public" class="form-control select2" style="width: 100%;">
                <option value="">Выб.</option>
                <option value="1" <?php if(Request_RequestParams::getParamBoolean('is_public') === true){echo 'selected';} ?>>Да</option>
                <option value="0" <?php if(Request_RequestParams::getParamBoolean('is_public') === false){echo 'selected';} ?>>Нет</option>
            </select>
        </td>
        <td colspan="2">
            <input class="form-control" type="text" name="number" style="min-width: 96px;" value="<?php echo Request_RequestParams::getParamStr('number');?>">
        </td>
        <td>
            <input class="form-control" type="datetime" date-type="date" name="created_at_date" style="min-width: 88px;" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('created_at_date'));?>">
        </td>
        <td>
            <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" class="form-control" type="text" name="amount" value="<?php echo Func::getNumberStr(Request_RequestParams::getParamFloat('amount'), true, 2);?>">
        </td>
        <td>
            <input class="form-control" type="datetime" date-type="date" name="from_at" style="min-width: 88px;" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('from_at'));?>">
        </td>
        <td>
            <input class="form-control" type="datetime" date-type="date" name="to_at" style="min-width: 88px;" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('to_at'));?>">
        </td>
        <td style="min-width: 113px;">
            <select name="main_client_contract_type_id" class="form-control select2" style="width: 100%;">
                <option value="-1">Выберите</option>
                <?php
                $tmp = 'data-id="'.Request_RequestParams::getParamInt('client_contract_type_id').'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::client-contract/type/list/list']));
                ?>
            </select>
        </td>
        <td>
            <input class="form-control" type="text" name="subject" value="<?php echo Request_RequestParams::getParamStr('subject');?>">
        </td>
        <td style="min-width: 113px;">
            <select name="client_contract_status_id" class="form-control select2" style="width: 100%;">
                <option value="-1">Выберите</option>
                <?php
                $tmp = 'data-id="'.Request_RequestParams::getParamInt('client_contract_status_id').'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::client-contract/status/list/list']));
                ?>
            </select>
        </td>
        <td style="min-width: 113px;">
            <select name="executor_shop_worker_id" class="form-control select2" style="width: 100%;">
                <option value="-1">Выберите</option>
                <?php
                $tmp = 'data-id="'.Request_RequestParams::getParamInt('executor_shop_worker_id').'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/worker/list/list']));
                ?>
            </select>
        </td>
        <td></td>
        <td>
            <div class="input-group" style="width: 145px;">
                <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                    <?php $tmp = Request_RequestParams::getParamInt('limit_page'); ?>
                    <option value="25" <?php if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} ?>>25</option>
                    <option value="50" <?php if($tmp == 50){echo 'selected';} ?>>50</option>
                    <option value="100" <?php if($tmp == 100){echo 'selected';} ?>>100</option>
                    <option value="200" <?php if($tmp == 200){echo 'selected';} ?>>200</option>
                    <option value="500" <?php if($tmp == 500){echo 'selected';} ?>>500</option>
                    <option value="1000" <?php if($tmp == 1000){echo 'selected';} ?>>1000</option>
                    <option value="5000" <?php if($tmp == 5000){echo 'selected';} ?>>5000</option>
                </select>
                <span class="input-group-btn">
                    <button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                </span>
            </div>
        </td>
    </form>
    <?php
    foreach ($data['view::_shop/client/contract/one/index']->childs as $value) {
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
    .select2-dropdown.select2-dropdown--below{
        min-width: 210px !important;
    }
</style>