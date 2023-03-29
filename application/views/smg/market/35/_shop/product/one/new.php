<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Артикул
    </label>
    <div class="col-md-4">
        <input name="article" type="text" class="form-control" placeholder="Артикул">
    </div>
    <label class="col-md-2 control-label">
        Штрихкод
    </label>
    <div class="col-md-4">
        <input name="barcode" type="text" class="form-control" placeholder="Штрихкод">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Статус
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_product_status_id" name="shop_product_status_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/status/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Бренд
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_brand_id" name="shop_brand_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/brand/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Рубрика
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_rubric_id" name="shop_rubric_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/rubric/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Поставщик
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Цена продажи
    </label>
    <div class="col-md-4">
        <input name="price" type="text" class="form-control" placeholder="Цена" required>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Себестоимость
    </label>
    <div class="col-md-4">
        <input name="price_cost" type="text" class="form-control" placeholder="Себестоимость">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Описание
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Описание" class="form-control"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
