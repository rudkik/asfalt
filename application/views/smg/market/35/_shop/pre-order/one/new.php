<div class="form-group">
    <div class="col-md-2">
        <label class="span-checkbox">
            <input name="is_check" value="0" style="display: none;">
            <input name="is_check" type="checkbox" class="minimal">
            Контроль
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        № документа
    </label>
    <div class="col-md-4">
        <input name="number" type="text" class="form-control" placeholder="№ документа">
    </div>
    <label class="col-md-2 control-label">
        Дата документа
    </label>
    <div class="col-md-4">
        <input name="date" type="datetime"  date-type="date"  class="form-control"  >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Сумма
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Сумма"  readonly>
    </div>
    <label class="col-md-2 control-label">
        Количество
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Количество"  readonly>
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
        Адреса поставщика
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_supplier_address_id" name="shop_supplier_address_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/supplier/address/list/list']; ?>
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
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>