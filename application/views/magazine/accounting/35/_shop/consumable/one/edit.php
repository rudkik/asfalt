<div class="inline-block">
    <h3 class="pull-left">Расходник <small style="margin-right: 10px;">редактирование</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitConsumable('shopconsumable');">Сохранить</button>
    <a href="<?php echo Func::getFullURL($siteData, '/shopreport/consumable_one', array(), array('shop_consumable_id' => $data->values['id'])); ?>" class="btn bg-info btn-flat pull-right" style="margin-right: 10px">Передача выручки</a>
</div>
<form id="shopconsumable" action="<?php echo Func::getFullURL($siteData, '/shopconsumable/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                № документа
            </label>
        </div>
        <div class="col-md-3">
            <input name="number" type="text" class="form-control" placeholder="№ документа" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" disabled>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Сумма
            </label>
        </div>
        <div class="col-md-3">
            <input name="amount" type="text" class="form-control input-amount" placeholder="Сумма" required value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'amount', ''), FALSE);?>">
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Дата документа
            </label>
        </div>
        <div class="col-md-3">
            <input name="created_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'created_at', ''));?>">
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                № ПКО
            </label>
        </div>
        <div class="col-md-3">
            <input name="pko_number" type="text" class="form-control" placeholder="№ ПКО" value="<?php echo htmlspecialchars(Arr::path($data->values, 'pko_number', ''), ENT_QUOTES);?>">
        </div>
        <div class="col-md-3 record-title">
            <label>
                Дата ПКО
            </label>
        </div>
        <div class="col-md-3">
            <input name="pko_date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'pko_date', ''));?>">
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
            <?php echo Helpers_Token::getInputTokenURL($siteData->url);?>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
        </div>
        <div class="modal-footer text-center">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/consumablexls', array(), array('id' => $data->values['id'])); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> Расходный кассовый ордер</a>

            <button type="button" class="btn btn-primary pull-right" onclick="submitConsumable('shopconsumable');">Сохранить</button>
            <button type="button" class="btn btn-primary pull-right" onclick="$('#is_close').val(0); submitConsumable('shopconsumable');">Применить</button>
        </div>
    </div>
</form>
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