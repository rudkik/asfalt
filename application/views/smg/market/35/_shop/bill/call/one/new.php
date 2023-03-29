<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
        <label class="span-checkbox">
            <input name="is_call" value="0" style="display: none">
            <input name="is_call" value="0" type="checkbox" class="minimal">
            Звонок совершон
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Заказа
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
        Статус зваонка
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
        <input name="phone" type="text" class="form-control" placeholder="Телефон" >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Время звонка
    </label>
    <div class="col-md-4">
        <input name="call_at" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время звонка" >
    </div>

    <label class="col-md-2 control-label">
        Время по плану
    </label>
    <div class="col-md-4">
        <input name="plan_call_at" type="datetime"  date-type="datetime"  class="form-control" placeholder="Время звонка" readonly>
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
        <textarea name="text" rows="5" placeholder="Комментарий после звонка" class="form-control"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>