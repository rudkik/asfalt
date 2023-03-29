<div class="form-group">
    <label class="col-md-2 control-label">Возврат</label>
    <div class="col-md-1">
        <label class="span-checkbox">
            <input name="is_return" value="0" style="display: none">
            <input name="is_return" <?php if (Arr::path($data->values, 'is_return', '0') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
             Совершон
        </label>
    </div>
    <div class="col-md-1">
        <label class="span-checkbox">
            <input name="is_refusal" value="0" style="display: none">
            <input name="is_refusal" <?php if (Arr::path($data->values, 'is_refusal', '0') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
             Отказан
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
            Заказ
    </label>
    <div class="col-md-10">
        <select id="shop_bill_id" name="shop_bill_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bill/list/list']; ?>
        </select>
    </div>
    </div>
<div class="form-group">

    <label class="col-md-2 control-label">
            Время возврата
    </label>
    <div class="col-md-4">
        <input name="return_at" type="date"  date-type="date"  class="form-control" placeholder="Время возврата" value="<?php echo htmlspecialchars($data->values['return_at'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
            Время планируемого возврата
    </label>
    <div class="col-md-4">
        <input name="plan_return_at" type="date"  date-type="date"  class="form-control" placeholder="Время планируемого возврата" value="<?php echo htmlspecialchars($data->values['plan_return_at'], ENT_QUOTES); ?>">
    </div>
    </div>
<div class="form-group">
    <label class="col-md-2 control-label">
            Статус возврата заказа
    </label>
    <div class="col-md-10">
        <select id="shop_bill_return_status_id" name="shop_bill_return_status_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bill/return/status/list/list']; ?>
        </select>
    </div>
    </div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Причина возврата
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Причина возврата" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
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
