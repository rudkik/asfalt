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
        <input name="number" type="text" class="form-control" placeholder="№ счета" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" disabled>
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
            <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                    data-date="<?php echo $data->values['created_at'];?>"
                    data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-less-zero="false">
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
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
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Возврат за
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/payment/return/item/list/index'];?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить строчку</button>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-9">
        <input disabled id="total" data-amount="<?php echo $data->values['amount']; ?>" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/consumable_return_xls', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Расходник</a>

        <button type="button" class="btn btn-primary pull-right" onclick="submitPaymentReturn('shoppaymentreturn');">Сохранить</button>
        <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitPaymentReturn('shoppaymentreturn');">Применить</button>
    </div>
</div>
<script>
    function submitPaymentReturn(id) {
        var isError = false;

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