<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"  data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                    data-date="<?php echo $data->values['created_at'];?>"
                    data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-less-zero="false">
                <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" date-type="date" class="form-control" required value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'date', ''));?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Договор
        </label>
    </div>
    <div class="col-md-3">
        <?php if($isShow){?><input name="shop_client_contract_id" value="<?php echo $data->values['shop_client_contract_id'];?>" style="display: none;"><?php }?>
        <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                id="shop_client_contract_id" name="shop_client_contract_id" class="form-control select2" style="width: 100%" data-contract-id="<?php echo $data->values['shop_client_contract_id'];?>" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Гарантийное письмо
        </label>
    </div>
    <div class="col-md-3">
        <?php if($isShow){?><input name="shop_client_guarantee_id" value="<?php echo $data->values['shop_client_guarantee_id'];?>" style="display: none;"><?php }?>
        <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                id="shop_client_guarantee_id" name="shop_client_guarantee_id" class="form-control select2" style="width: 100%" data-guarantee-id="<?php echo $data->values['shop_client_guarantee_id'];?>" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
        </select>
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
        <button type="button" class="btn btn-primary" onclick="submitPaymentSchedule('shoppaymentschedule');">Сохранить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPaymentSchedule('shoppaymentschedule');">Применить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#shop_client_id').change(function () {
            var basicURL = $(this).data('basic-url');
            var client = $(this).val();
            loadBasicContract(client, $('#shop_client_contract_id'), basicURL);
            loadGuarantee(client, $('#shop_client_guarantee_id'), basicURL);
        }).trigger('change');
    });
    
    function submitPaymentSchedule(id) {
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
            $('#'+id).submit();
        }
    }
</script>