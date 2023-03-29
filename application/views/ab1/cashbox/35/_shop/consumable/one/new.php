<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № документа
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ документа" value="" disabled>
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
            Сумма
        </label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required>
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
        if (!$.isNumeric(element.valNumber()) || parseFloat(element.valNumber()) <= 0){
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