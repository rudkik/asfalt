<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № документа
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ документа" <?php if(!$siteData->operation->getIsAdmin()){ ?>disabled<?php } ?>>
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
        <label>Договор</label>
    </div>
    <div class="col-md-9">
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="-1" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без договора</option>
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
        <input disabled id="total" data-amount="0" name="amount" type="text" class="form-control input-amount" required placeholder="Сумма">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Способ оплаты
        </label>
    </div>
    <div class="col-md-3">
        <select id="payment_type_id" name="payment_type_id" class="form-control select2" required style="width: 100%">
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
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitPayment('shoppayment');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitPayment('shoppayment');">Сохранить</button>
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
