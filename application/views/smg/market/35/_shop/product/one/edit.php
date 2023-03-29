<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Артикул
    </label>
    <div class="col-md-4">
        <input name="article" type="text" class="form-control" placeholder="Артикул" value="<?php echo htmlspecialchars($data->values['article'], ENT_QUOTES);?>">
    </div>
    <label class="col-md-2 control-label">
        Штрихкод
    </label>
    <div class="col-md-4">
        <input name="barcode" type="text" class="form-control" placeholder="Штрихкод" value="<?php echo htmlspecialchars($data->values['barcode'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
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
        <input name="price" type="text" class="form-control" placeholder="Цена" required value="<?php echo htmlspecialchars($data->values['price'], ENT_QUOTES);?>">
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Себестоимость
    </label>
    <div class="col-md-4">
        <input name="price_cost" type="text" class="form-control" placeholder="Себестоимость" value="<?php echo htmlspecialchars($data->values['price_cost'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Описание
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Описание" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
    </div>
</div>
<?php echo $siteData->replaceDatas['view::_shop/product/attribute/list/index']; ?>
<div class="form-group">

    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>