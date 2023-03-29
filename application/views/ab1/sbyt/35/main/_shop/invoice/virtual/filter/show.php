<?php
$time2 = Request_RequestParams::getParamDateTime('date_to');
if(empty($time2)) {
    $time2 = date('d.m.Y', strtotime('+1 day')) . ' 06:00';
}else{
    $time2 = Helpers_DateTime::getDateTimeFormatRus($time2);
}

$time1 = Request_RequestParams::getParamDateTime('date_from');
if(empty($time1)) {
    $time1 = date('d.m.Y') . ' 06:00';
}else{
    $time1 = Helpers_DateTime::getDateTimeFormatRus($time1);
}
?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_from">Период от</label>
                        <div class="input-group">
                            <div class="input-group-btn">
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_show', array(),
                                    array(
                                        'date_from' => date('Y-m-d', strtotime($time1 . ' -1 day')).' 06:00:00',
                                        'date_to' => date('Y-m-d', strtotime($time2 . ' -1 day')).' 06:00:00',
                                    ), array(), true); ?>" class="btn btn-success btn-flat"><i class="fa  fa-angle-left"></i></a>
                            </div>
                            <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_to">Период до</label>
                        <div class="input-group">
                            <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            <div class="input-group-btn">
                                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_show', array(),
                                    array(
                                        'date_from' => date('Y-m-d', strtotime($time1 . ' +1 day')).' 06:00:00',
                                        'date_to' => date('Y-m-d', strtotime($time2 . ' +1 day')).' 06:00:00',
                                    ), array(), true); ?>" class="btn btn-success btn-flat"><i class="fa  fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Клиент</label>
                        <div class="input-group">
                            <?php echo trim($siteData->globalDatas['view::_shop/client/one/show-invoice']); ?>
                            <div class="input-group-btn">
                                <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array(),
                                    array(
                                        'id' => Request_RequestParams::getParamInt('shop_client_id'),
                                    )); ?>" class="btn btn-select btn-flat"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_client_attorney_id">Выдано по</label>
                        <div class="input-group box-select2">
                            <select id="shop_client_attorney_id" name="shop_client_attorney_id" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0">Наличные</option>
                                <?php echo trim($siteData->globalDatas['view::_shop/client/attorney/list/option']); ?>
                            </select>
                            <div class="input-group-btn">
                                <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/index', array(),
                                    array(
                                        'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                                    )); ?>" class="btn btn-select btn-flat"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_client_contract_id">Договор</label>
                        <div class="input-group box-select2">
                            <select id="shop_client_contract_id" name="shop_client_contract_id" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0">Без договора</option>
                                <?php echo trim($siteData->globalDatas['view::_shop/client/contract/list/list']); ?>
                            </select>
                            <div class="input-group-btn">
                                <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(),
                                    array(
                                        'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                                    )); ?>" class="btn btn-select btn-flat"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');
                if($isDelivery !== NULL){
                    ?>
                    <div class="col-md-2">
                        <div class="form-group" style="margin-bottom: 5px">
                            <label for="is_delivery">Доставка</label>
                            <select id="is_delivery" name="is_delivery" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0" <?php if(!$isDelivery){echo 'selected';} ?>>Без доставки</option>
                                <option value="1" data-id="1" <?php if($isDelivery){echo 'selected';} ?>>С доставкой</option>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="product_type_id">Вид продукта</label>
                        <select id="product_type_id" name="product_type_id" class="form-control select2" style="width: 100%;">
                            <?php echo trim($siteData->globalDatas['view::product/type/list/list']); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>

                        <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                            <input id="input-status" name="is_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                            <input id="input-status" name="is_not_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                            <input id="input-status" name="is_delete" value="1">
                        <?php }else{?>
                            <input id="input-status" name="" value="1">
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="pull-right">
                        <button type="submit" class="btn bg-orange btn-flat" style="margin-top: 25px;"><i class="fa fa-fw fa-search"></i> Поиск</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 class="text-blue">
                        <span>Балансы на <?php echo date('d.m.Y H:s');?></span>
                        <a href="<?php echo Func::getFullURL($siteData, '/shopclient/calc_balance', array(), array('id' => Request_RequestParams::getParamInt('shop_client_id'), 'url' => '/sbyt/shopinvoice/virtual_show'.URL::query())); ?>" style="margin-left: 15px;font-size: 16px;" class="link-green"><i class="fa fa-calculator margin-r-5"></i> Пересчитать баланс</a>
                    </h4>
                    <?php echo trim($siteData->globalDatas['view::_shop/client/one/invoice-balance']); ?>
                    <?php echo trim($siteData->globalDatas['view::_shop/client/attorney/list/invoice']); ?>
                </div>
                <div class="col-md-7">
                    <h4 class="text-blue">
                        <span>Итоги на <?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDateTime('date_to'));?></span>
                    </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Договор</label>
                                <input type="text" class="form-control" value="<?php echo Func::getNumberStr($siteData->replaceDatas['balance_contract'], true, 2, false);?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Доверенность</label>
                                <input type="text" class="form-control" value="<?php echo Func::getNumberStr($siteData->replaceDatas['balance_attorney'], true, 2, false);?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Наличные</label>
                                <input type="text" class="form-control" value="<?php echo Func::getNumberStr($siteData->replaceDatas['balance_cash'], true, 2, false);?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Общий баланс</label>
                                <input type="text" class="form-control" value="<?php echo Func::getNumberStr($siteData->replaceDatas['balance'], true, 2, false);?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</form>
<script>
    $('#shop_client_attorney_id').change(function (){
        var attorney = $(this).val();
        var amount = $(this).find('option[value="' + attorney + '"]').data('amount');

        if(amount === undefined){
            amount = $('#shop_client_name').data('amount');
        }
        if(amount == 'NaN'){
            amount = 0;
        }

        $('#balance').valNumber(amount);
    });
</script>