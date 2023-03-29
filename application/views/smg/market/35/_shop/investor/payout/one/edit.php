
<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата вклада" value="<?php echo Helpers_DateTime::getDateFormatRus(htmlspecialchars($data->values['date'], ENT_QUOTES)); ?>" >
    </div>

    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input name="amount" type="text" class="form-control" placeholder="Сумма" value="<?php echo htmlspecialchars($data->values['amount'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Инвестор
    </label>
    <div class="col-md-10">
        <select id="shop_investor_id" name="shop_investor_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/investor/list/list']; ?>
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
