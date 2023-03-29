<div class="form-group">
    <label class="col-md-2 control-label">
        № документа
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="№ документа" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>" readonly>
    </div>
    <label class="col-md-2 control-label">
        Дата документа
    </label>
    <div class="col-md-4">
        <input type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Сумма" value="<?php echo Func::getNumberStr($data->values['amount'], ENT_QUOTES); ?>" readonly>
    </div>
    <label class="col-md-2 control-label">
        Количество
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Количество" value="<?php echo Func::getNumberStr($data->values['quantity'], ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Поставщик
    </label>
    <div class="col-md-10">
        <input type="text" class="form-control" placeholder="Поставщик" value="<?php echo htmlspecialchars($data->getElementValue('shop_supplier_id'), ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Адрес поставщика
    </label>
    <div class="col-md-10">
        <input type="text" class="form-control" placeholder="Адрес поставщика" value="<?php echo htmlspecialchars($data->getElementValue('shop_supplier_address_id'), ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Товары
    </label>
    <div class="col-md-10" style="overflow-x: auto;">
        <?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/receive']); ?>
    </div>
</div>
<?php if($data->values['is_buy'] == 0){ ?>
    <div class="row">
        <div hidden>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <input name="is_buy" value="1">
        </div>
        <div class="modal-footer text-center">
            <button type="submit" class="btn bg-green" data-action="form-apply">Куплен</button>
        </div>
    </div>
<?php } ?>
