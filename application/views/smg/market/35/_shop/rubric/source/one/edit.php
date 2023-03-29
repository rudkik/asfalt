<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '0') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
            Показать
        </label>
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
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Родитель
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="root_id" name="root_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/rubric/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Источников интеграции
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_sale" value="0" style="display: none">
            <input name="is_sale" <?php if (Arr::path($data->values, 'is_sale', '0') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
            Считать комиссию по акции?
        </label>
    </div>
    <label class="col-md-2 control-label">
        Наценка на рубрику
    </label>
    <div class="col-md-4">
        <input name="markup" type="text" class="form-control" placeholder="Наценка на рубрику" value="<?php echo htmlspecialchars($data->values['markup'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw"></i></sup>
        Комиссия (%)
    </label>
    <div class="col-md-4">
        <input name="commission" type="text" class="form-control" placeholder="Комиссия (%)"  value="<?php echo htmlspecialchars($data->values['commission'], ENT_QUOTES);?>">
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw"></i></sup>
        Комиссия при акции (%)
    </label>
    <div class="col-md-4">
        <input name="commission_sale" type="text" class="form-control" placeholder="Комиссия при акции (%)"  value="<?php echo htmlspecialchars($data->values['commission_sale'], ENT_QUOTES);?>">
    </div>
</div>
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