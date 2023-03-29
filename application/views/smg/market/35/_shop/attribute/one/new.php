

<div class="form-group">
    <label class="col-md-2 control-label">
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" value="">
    </div>
</div>
<div class="form-group">

    <label class="col-md-2 control-label">
        Атрибут
    </label>
    <div class="col-md-10">
        <select id="shop_attribute_id" name="shop_attribute_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/attribute/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">

    <label class="col-md-2 control-label">
        Продукция
    </label>
    <div class="col-md-10">
        <select id="shop_product_id" name="shop_product_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">

    <label class="col-md-1 control-label">
        Атрибут
    </label>
    <label class="col-md-1 control-label">
        Тип
    </label>
    <div class="col-md-4">
        <select id="shop_product_attribute_type_id" name="shop_product_attribute_type_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/attribute/type/list/list']; ?>
        </select>
    </div>
    <label class="col-md-2 control-label">
        Рубрика
    </label>
    <div class="col-md-4">
        <select id="shop_product_attribute_rubric_id" name="shop_product_attribute_rubric_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/attribute/rubric/list/list']; ?>
        </select>
    </div>
</div>

<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>