<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select data-client="-1" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-less-zero="false"
                    data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
            </select>
            <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
            <span class="input-group-btn"> <a class="btn btn-flat box-amount-p"><b id="client-amount" class="text-navy" style="font-size: 18px;"></b></a></span>
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
        <input name="date" type="datetime" date-type="date" class="form-control" required value="<?php echo date('d.m.Y');?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required >
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
           Договор
        </label>
    </div>
    <div class="col-md-9">
        <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                id="shop_client_contract_id" name="shop_client_contract_id" class="form-control select2" style="width: 100%" style="width: 100%">
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Гарантийное письмо
        </label>
    </div>
    <div class="col-md-9">
        <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                id="shop_client_guarantee_id" name="shop_client_guarantee_id" class="form-control select2" style="width: 100%" style="width: 100%">
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPayment('shoppaymentschedule');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitPayment('shoppaymentschedule');">Сохранить</button>
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

    function submitPayment(id) {
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
