<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Штрихкод
        </label>
    </div>
    <div class="col-md-3">
        <input autocomplete="off" data-type="barcode1" name="barcode" type="tel" class="form-control" placeholder="Штрихкод" value="<?php echo htmlspecialchars(Arr::path($data->values, 'barcode', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ID 1C
        </label>
    </div>
    <div class="col-md-3">
        <input name="old_id" type="text" class="form-control" placeholder="ID 1C" value="<?php echo htmlspecialchars(Arr::path($data->values, 'old_id', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рубрика
        </label>
    </div>
    <div class="col-md-3">
        <select data-type="select2" id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Единица измерения
        </label>
    </div>
    <div class="col-md-3">
        <select data-type="select2" id="unit_id" name="unit_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::unit/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Себестоимость
        </label>
    </div>
    <div class="col-md-3">
        <input type="tel" name="price_cost" class="form-control" placeholder="Себестоимость" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'price_cost', ''));?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Коэффициент ревизии
        </label>
    </div>
    <div class="col-md-3">
        <input type="tel" name="coefficient_revise" class="form-control" placeholder="Коэффициент ревизии" value="<?php echo Arr::path($data->values, 'coefficient_revise', '');?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Наценка
        </label>
    </div>
    <div class="col-md-3">
        <input name="markup" type="phone" class="form-control" placeholder="Наценка" value="<?php echo Arr::path($data->values, 'markup', '');?>" required>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_markup_percent" <?php if (Arr::path($data->values, 'is_markup_percent', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Наценка в процентах
        </label>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>