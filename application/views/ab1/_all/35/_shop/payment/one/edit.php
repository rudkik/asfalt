<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<?php
$view = View::factory('ab1/_all/35/fiscal-registrar');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ счета" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>"  <?php if(!$siteData->operation->getIsAdmin()){ ?>disabled<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            № чека
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="№ чека" value="<?php echo htmlspecialchars(Arr::path($data->values, 'fiscal_check', ''), ENT_QUOTES);?>" disabled>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <?php if($isShow){ ?>
                <input name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none">
            <?php } ?>
            <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"  data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                    data-date="<?php echo $data->values['created_at'];?>"
                    data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-less-zero="false" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
            <?php if(!$isShow){ ?>
            <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
            <?php } ?>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $data->getElementValue('shop_client_id', 'balance'), TRUE, FALSE); ?></b></a></span>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Договор</label>
    </div>
    <div class="col-md-9">
        <?php if($isShow){ ?>
            <input name="shop_client_contract_id" value="<?php echo $data->values['shop_client_contract_id']; ?>" style="display: none">
        <?php } ?>
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" required style="width: 100%;"  <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без договора</option>
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list" style="margin-top: 30px">
    <div class="col-md-3 record-title">
        <label>
            Цены на дату
        </label>
    </div>
    <div class="col-md-3">
        <input id="current" type="datetime" date-type="date" class="form-control">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Оплата за
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/payment/item/list/index'];?>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <input disabled id="total" data-amount="<?php echo $data->values['amount']; ?>" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Способ оплаты
        </label>
    </div>
    <div class="col-md-3">
        <?php if($isShow){ ?>
            <input name="payment_type_id" value="<?php echo $data->values['payment_type_id']; ?>" style="display: none">
        <?php } ?>
        <select id="payment_type_id" name="payment_type_id" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Выберите способ оплаты</option>
            <?php echo $siteData->globalDatas['view::payment-type/list/list'];?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Посттерминал (при оплатой картой)
        </label>
    </div>
    <div class="col-md-3">
        <?php if($isShow){ ?>
            <input name="shop_cashbox_terminal_id" value="<?php echo $data->values['shop_cashbox_terminal_id']; ?>" style="display: none">
        <?php } ?>
        <select id="shop_cashbox_terminal_id" name="shop_cashbox_terminal_id" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Выберите посттерминал</option>
            <?php echo $siteData->globalDatas['view::_shop/cashbox/terminal/list/list'];?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1">
        <input id="shop_branch_id" name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
    </div>
    <div class="modal-footer text-center">
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/orderxls_payment', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Счет / ПКО</a>
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/pkoxls_payment', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> ПКО</a>

        <?php if(!$isShow){ ?>
        <?php if($data->values['is_fiscal_check'] == 1){?>
            <button type="button" class="btn btn-primary pull-right" onclick="submitPayment('shoppayment');">Сохранить</button>
            <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitPayment('shoppayment');">Применить</button>
        <?php }else{?>
            <button type="button" class="btn btn-primary pull-right" onclick="$('#dialog-fiscla-check').modal('show');">Сохранить</button>
            <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); $('#dialog-fiscla-check').modal('show');">Применить</button>
        <?php }?>
        <?php } ?>
    </div>
</div>
<?php if(!$isShow){ ?>
<div id="dialog-fiscla-check" class="modal">
    <div class="modal-dialog" style="max-width: 300px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Чек распечатался?</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Номер чека</label>
                                <input class="form-control" name="fiscal_check" placeholder="Номер чека" type="text" value="<?php echo $data->values['fiscal_check']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input id="is_fiscal_check" name="is_fiscal_check" value="<?php echo $data->values['is_fiscal_check']; ?>" style="display: none">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="$('#is_fiscal_check').val(0); submitPayment('shoppayment');">Нет</button>
                <button type="button" class="btn btn-primary pull-right" onclick="$('#is_fiscal_check').val(1); submitPayment('shoppayment');">Да</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#shop_client_id, #shop_client_contract_id').change(function () {
        $('[data-action="calc-payment"]').trigger('change');
    });
    function submitPayment(id) {
        var isError = false;

        var element = $('[name="payment_type_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="amount"]');
        var v = element.valNumber();
        if (!$.isNumeric(v) || parseFloat(v) <= 0){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            tmp = $('input[disabled][name]');
            tmp.removeAttr('disabled');
            $('#'+id).submit();
            tmp.attr('disabled', '');
        }
    }
</script>
<?php } ?>
