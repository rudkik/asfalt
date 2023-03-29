<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
        <label class="span-checkbox">
            <input name="is_call" value="0" style="display: none">
            <input name="is_call" <?php if (Arr::path($data->values, 'is_call', '0') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
            Звонок совершон
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
        Статус звонка
    </label>
    <div class="col-md-10">
        <select id="shop_bill_call_status_id" name="shop_bill_call_status_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/bill/call/status/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Телефон
    </label>
    <div class="col-md-4">
        <input name="phone" type="text" class="form-control" placeholder="Телефон" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Время звонка
    </label>
    <div class="col-md-4">
        <input name="call_at" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время звонка" value="<?php echo htmlspecialchars($data->values['call_at'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
        Время по плану
    </label>
    <div class="col-md-4">
        <input name="plan_call_at" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время звонка" value="<?php echo htmlspecialchars($data->values['plan_call_at'], ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Оператор
    </label>
    <div class="col-md-10">
        <select id="shop_operation_id" name="shop_operation_id" class="form-control select2"  style="width: 100%;" disabled>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/operation/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Комментарий после звонка
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Комментарий после звонка" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
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
