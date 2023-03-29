<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-2">
        <label class="span-checkbox">
            <input name="is_nds" value="0" style="display: none;">
            <input name="is_nds" <?php if (Arr::path($data->values, 'is_nds', '1') == 1) { echo ' value="1" checked'; } ?> type="checkbox" class="minimal">
            НДС
        </label>
    </div>
    <div class="col-md-2">
        <label class="span-checkbox">
            <input name="is_check" value="0" style="display: none;">
            <input name="is_check" <?php if (Arr::path($data->values, 'is_check', '1') == 1) { echo ' value="1" checked'; } ?> type="checkbox" class="minimal">
            Контроль
        </label>
    </div>
    <?php if($data->values['is_return'] == 1){ ?>
        <div class="col-md-6">
            <label class="span-checkbox"><b>Возврат</b></label>
        </div>
    <?php } ?>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        № документа
    </label>
    <div class="col-md-4">
        <input name="number" type="text" class="form-control" placeholder="№ документа" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>">
    </div>
    <label class="col-md-2 control-label">
        Дата документа
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        № ЭСФ
    </label>
    <div class="col-md-4">
        <input name="esf_number" type="text" class="form-control" placeholder="№ ЭСФ" value="<?php echo htmlspecialchars($data->values['esf_number'], ENT_QUOTES); ?>" readonly>
    </div>
    <label class="col-md-2 control-label">
        Дата ЭСФ
    </label>
    <div class="col-md-4">
        <input name="esf_date" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['esf_date']); ?>" readonly>
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
        <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Курьер
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_courier_id" name="shop_courier_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/courier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Комментарии
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="2" placeholder="Комментарии" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Товары ЭСФ
    </label>
    <div class="col-md-10">
        <?php echo trim($siteData->globalDatas['view::_shop/receive/item/list/index']); ?>
    </div>
</div>
<?php if($data->values['is_return'] == 0) { ?>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Возврат товаров
        </label>
        <div class="col-md-10">
            <?php echo trim($siteData->globalDatas['view::_shop/receive/item/list/return']); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Товары
        </label>
        <div class="col-md-10">
            <?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/receive-edit']); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Свободные товары заказа
        </label>
        <div class="col-md-10">
            <?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/receive-new']); ?>
        </div>
    </div>
<?php } ?>
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
