<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ счета" value="" disabled>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сумма
        </label>
    </div>
    <div class="col-md-3">
        <input name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Дата документа
        </label>
    </div>
    <div class="col-md-3">
        <input name="created_at" type="datetime" date-type="date" class="form-control" value="<?php echo date('d.m.Y');?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № ПКО
        </label>
    </div>
    <div class="col-md-3">
        <input name="pko_number" type="text" class="form-control" placeholder="№ ПКО">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата ПКО
        </label>
    </div>
    <div class="col-md-3">
        <input name="pko_date" type="datetime" date-type="date" class="form-control">
    </div>
</div>

<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <h4 style="font-weight: bold;">Для расходно-кассового ордера</h4>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Период от
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="datetime" class="form-control">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Период до
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="datetime" class="form-control">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Выдать
        </label>
    </div>
    <div class="col-md-9">
        <input name="extradite" type="text" class="form-control" placeholder="Выдать" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Основание
        </label>
    </div>
    <div class="col-md-9">
        <input name="base" type="text" class="form-control" placeholder="Основание">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary pull-right" onclick="submitConsumable('shopconsumable');">Сохранить</button>
        <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitConsumable('shopconsumable');">Применить</button>
    </div>
</div>
<script>
    function submitConsumable(id) {
        var isError = false;

        var element = $('[name="amount"]');
        if (!$.isNumeric(element.val()) || parseFloat(element.val()) <= 0){
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