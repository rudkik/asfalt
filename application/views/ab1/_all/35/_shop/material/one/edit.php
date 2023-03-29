<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_weighted" <?php if (Arr::path($data->values, 'is_weighted', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать в Весовой
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_moisture_and_density" <?php if (Arr::path($data->values, 'is_moisture_and_density', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Возможно ли испытание на влажность и плотность
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
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_site', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рубрика
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Рубрика для производства
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_material_rubric_make_id" name="shop_material_rubric_make_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/rubric/make/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Единица измерения учета
        </label>
    </div>
    <div class="col-md-3">
        <input name="unit" type="text" class="form-control" placeholder="Единица измерения" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'unit', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Единица измерения рецепта
        </label>
    </div>
    <div class="col-md-3">
        <input name="unit_recipe" type="text" class="form-control" placeholder="Единица измерения рецепта" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'unit_recipe', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Коэффициент для рецептов
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="coefficient_recipe" type="phone" class="form-control" placeholder="Коэффициент для рецептов" required value="<?php echo Func::getNumberStr(Arr::path($data->values, 'coefficient_recipe', ''), true, 3);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Виды рецептов
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="formula_type_ids" name="formula_type_ids[]" class="form-control select2" multiple required style="width: 100%;">
                <?php echo $siteData->globalDatas['view::formula-type/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Материал доступен для рецептов
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="access_formula_type_ids" name="access_formula_type_ids[]" class="form-control select2" multiple required style="width: 100%;">
                <?php echo $siteData->globalDatas['view::formula-type/list/access']; ?>
            </select>
        </div>
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