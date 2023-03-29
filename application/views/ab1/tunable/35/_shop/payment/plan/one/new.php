<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control" placeholder="Сумма">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" class="form-control" placeholder="Дата">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPaymentPlan('shoppaymentplan');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitPaymentPlan('shoppaymentplan');">Сохранить</button>
    </div>
</div>
<script>
    function submitPaymentPlan(id) {
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
