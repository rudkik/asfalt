<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № расходника
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="№ расходника" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата создания
        </label>
    </div>
    <div class="col-md-3">
        <input name="created_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'created_at', ''));?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Период от
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'from_at', ''));?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Период до
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'to_at', ''));?>">
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
        <input data-type="money" data-fractional-length="2" name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required value="<?php echo Func::getNumberStr( Arr::path($data->values, 'amount', ''), true);?>">
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
        <input name="extradite" type="text" class="form-control" placeholder="Выдать" value="<?php echo htmlspecialchars(Arr::path($data->values, 'extradite', ''), ENT_QUOTES);?>" required>
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
        <input name="base" type="text" class="form-control" placeholder="Основание" value="<?php echo htmlspecialchars(Arr::path($data->values, 'base', ''), ENT_QUOTES);?>">
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
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/consumablexls', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Печатать</a>

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