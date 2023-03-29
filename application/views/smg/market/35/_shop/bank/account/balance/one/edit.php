<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" >
    </div>
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], ENT_QUOTES); ?>" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
            Компания
    </label>
    <div class="col-md-4">
        <select id="shop_company_id" name="shop_company_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/company/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Номер счёта
    </label>
    <div class="col-md-4">
        <select id="shop_bank_account_id" name="shop_bank_account_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
