<form id="proforma" action="<?php echo Func::getFullURL($siteData, '/shopinvoiceproforma/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дата счета
            </label>
        </div>
        <div class="col-md-3">
            <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo date('d.m.Y');?>">
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Общая сумма счета
            </label>
        </div>
        <div class="col-md-3">
            <input id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма счета" readonly>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Клиент
            </label>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                        data-contract="#shop_client_contract_id"
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                </select>
                <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
            </div>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Договор
            </label>
        </div>
        <div class="col-md-3">
            <select data-url="/<?php echo $siteData->actionURLName; ?>/shopclientcontract/json?_fields[]=number&_fields[]=from_at"
                    id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="-1" class="form-control select2" style="width: 100%;">
                <option value="0" data-id="0">Без договора</option>
            </select>
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
            <h3 class="pull-right">
                Продукция
            </h3>
        </div>
        <div class="col-md-9">
            <?php echo $siteData->globalDatas['view::_shop/invoice/proforma/item/list/index'];?>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <input id="is_close" name="is_close" value="1">
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(1); submitPayment('proforma');">Сохранить</button>
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPayment('proforma');">Применить</button>
        </div>
    </div>
</form>
<script>
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
            tmp = $('input[disabled][name]');
            tmp.removeAttr('disabled');
            $('#'+id).submit();
            tmp.attr('disabled', '');
        }
    }
</script>